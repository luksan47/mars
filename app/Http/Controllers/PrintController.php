<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

use App\User;
use App\PrintAccount;
use App\PrintJob;
use App\Utils\TabulatorPaginator;


class PrintController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:print.print');
    }

    public function index() {
        return view('print.app', ["users" => User::all()]);
    }

    public function print(Request $request) {
    
        if (!config('printing.enabled'))
            return back()->withErrors(['print' => __('print.not_available')]);
    
        $validator = Validator::make($request->all(), [
            'file_to_upload' => 'required|file|mimes:pdf|max:5242880',
            'number_of_copies' => 'required|integer|min:1'
        ]);
        $validator->validate();

        $print_account = Auth::user()->printAccount;
        $is_two_sided = $request->has('two_sided');
        $file = $request->file_to_upload;
        $number_of_copies = $request->number_of_copies;
        $pages = $this->getPages($validator, $file->getPathName());

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $cost = PrintAccount::getCost($pages, $is_two_sided, $number_of_copies);
        
        if (!$print_account->hasEnoughMoney($cost)) {
            return $this->handleNoBalance($validator);
        }
        
        // FIXME: $print_accout->decrement or PrintJob::create() might
        //        fail but the job might still get queued, 
        //        leaving the whole thing in an inconsistent state;
        //        some kind of rollback mechanism should be used with
        //        lpstat, $print_accout->decrement, and PrintJob::create()
        if ($this->printFile($file, $cost, $is_two_sided, $number_of_copies)) {
            $print_account->decrement('balance', $cost);
            return back()->with('print.status', __('print.successfully_queued'));
        } else {
            return back()->withErrors(['print' => __('print.error_printing')]);
        }
    }

    public function modifyBalance(Request $request) {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer|exists:users,id',
            'balance' => 'required|integer',
        ]);
        $validator->validate();

        $balance = $request->balance;
        $print_account = User::find($request->user_id)->printAccount;

        if ($balance < 0 && !$print_account->hasEnoughMoney($balance)) {
            return $this->handleNoBalance($validator);
        }

        $print_account->increment('balance', $balance);
        return redirect()->route('print');
    }

    public function modifyFreePages(Request $request) {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer|exists:users,id',
            'free_pages' => 'required|integer',
        ]);
        $validator->validate();

        $free_pages = $request->free_pages;
        $print_account = User::find($request->user_id)->printAccount;

        if ($print_account->free_pages + $free_pages < 0) {
            $validator->errors()->add('free_pages', __('print.no_free_pages_left'));
            return back()
                ->withErrors($validator)
                ->withInput();
        }
        $print_account->increment('free_pages', $free_pages);
        return redirect()->route('print');
    }

    public function listPrintJobs() {
        $this->authorize('viewAny', PrintJob::class);

        $columns = ['created_at', 'filename', 'cost', 'state'];
        if (Auth::user()->hasRole(\App\Role::PRINT_ADMIN)) {
            array_push($columns, 'user.name');
            $paginator = TabulatorPaginator::from(
                    PrintJob::join('users as user', 'user.id', '=', 'user_id')->select('print_jobs.*')->with('user')
                )->sortable($columns)->filterable($columns)->paginate();
        } else {
            $paginator = TabulatorPaginator::from(Auth::user()->printJobs())
                ->sortable($columns)->filterable($columns)->paginate();
        }

        $paginator->getCollection()->transform(PrintJob::translateStates());
        $paginator->getCollection()->transform(PrintJob::addCurrencyTag());
        return $paginator;
    }


    // TODO:  success and failure should be signalled
    //        to the caller somehow where needed
    // FIXME: cancel(1) might succeed but commiting changes
    //        to the database might fail leaving the whole thing
    //        in an inconsistent state;
    //        some kind of rollback mechanism should be used
    //        that respects the users wish to cancel the job
    public function cancelPrintJob($id) {
        
        abort_unless(config('printing.enabled'), 503); // 503 Service Unavailable
    
        $printJob = PrintJob::findOrFail($id);
        $this->authorize('update', $printJob);
        
        
        if ($printJob->state == PrintJob::QUEUED) {
            
            $output = exec(
                sprintf("cancel %s '%s' 2>&1",
                    config('printing.utility_args'),
                    $printJob->job_id),
                $result,
                $exit_code
            );
            
            // cancel(1) exits with status code 0 if it succeeds
            if ($exit_code == 0) {
                
                DB::transaction(function() use (&$printJob) {
                    $printJob->state = PrintJob::CANCELLED;
                    $printJob->save();
                    
                    Auth::user()->printAccount->increment('balance', $printJob->cost);
                });
            
            } else {
                
                // this is not a typo; it is "canceled" (US)
                if (strpos($output, "already canceled") !== false) {
                    
                    // assuming that this application has sole control
                    // over the printing server, this means that
                    // we must have cancelled this job just moments ago;
                    // which means that its state has been set to PrintJob::CANCELLED
                    // and the user's balance has been restored,
                    // so we do nothing
                    
                    // TODO: maybe some kind of check should be implemented
                    //       to see if the job has been cancelled by us
                    
                } else if (strpos($output, "already completed") !== false) {
                    
                    // this means that we're too late... the job has been finished,
                    // but this change hasn't been picked up by the scheduled
                    // PrintJobsUpdate command yet;
                    // we will change the state to PrintJob::COMPLETED so that
                    // the user can see that the job has already completed
                    
                    $printJob->state = PrintJob::COMPLETED;
                    $printJob->save();
                    
                } else {
                    Log::warning(
                        sprintf("cannot cancel print job '%s' for unknown reasons: '%s'",
                            $printJob->job_id,
                            $output
                    ));
                }
                
            }
        }
    }

    private function printFile($file, $cost, $is_two_sided, $number_of_copies) {
        $state = PrintJob::QUEUED;
        try {
            $path = $file->storeAs('', md5(rand(0, 100000) . date('c')) . '.pdf', 'printing');
            $path = Storage::disk('printing')->getDriver()->getAdapter()->applyPathPrefix($path);
			
            $result = exec(
                sprintf("lp %s -d '%s' -n %d %s '%s' 2>&1",
                    config('printing.utility_args'),
                    config('printing.printer_name'),
                    $number_of_copies,
                    ($is_two_sided ? "-o sides=two-sided-long-edge" : ""),
                    $path
            ));
            
            if (!preg_match("/request id is (?P<id>[^\s]*)/", $result, $job)) {
                Log::error("Printing error at line: " . __FILE__ . ":" . __LINE__ . " (in function " . __FUNCTION__ . "). result:"
                    . print_r($result, true));
                $state = PrintJob::ERROR;
            }
            $job_id = $job['id'];
        } catch (\Exception $e) {
            Log::error("Printing error at line: " . __FILE__ . ":" . __LINE__ . " (in function " . __FUNCTION__ . "). " . $e->getMessage());
            $state = PrintJob::ERROR;
            $job_id = "";
            $path = "";
        }
    
        PrintJob::create([
            'filename' => $file->getClientOriginalName(),
            'filepath' => $path,
            'user_id' => Auth::user()->id,
            'state' => $state,
            'job_id' => $job_id,
            'cost' => $cost,
        ]);

        return $state == PrintJob::QUEUED;
    }

    private function handleNoBalance($validator) {
        $validator->errors()->add('balance', __('print.no_balance'));
        return back()
            ->withErrors($validator)
            ->withInput();
    }

    private function getPages($validator, $path) {
        $pages = exec(sprintf("pdfinfo '%s' 2>&1 | grep '^Pages' | awk '{print $2}'", $path));
        
        if ($pages == "" || !is_numeric($pages) || $pages <= 0) {
            Log::error("Cannot get number of pages for uploaded file!" . print_r($pages, true));
            $validator->errors()->add('file_to_upload', __('print.invalid_pdf'));
        }
        return $pages;
    }
}
