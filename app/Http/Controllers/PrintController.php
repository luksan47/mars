<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Console\Commands;
use App\User;
use App\PrintAccount;
use App\FreePages;
use App\PrintJob;
use App\PrintAccountHistory;
use App\Utils\TabulatorPaginator;
use Illuminate\Support\Facades\DB;

class PrintController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:print.print');
    }

    public function index() {
        return view('print.app', [
                "users" => User::all(),
                "free_pages" => Auth::user()->sumOfActiveFreePages()
            ]);
    }

    public function admin() {
        Gate::authorize('print.admin');
        return view('admin.print.app', ["users" => User::all()]);
    }

    public function print(Request $request) {
        $validator = Validator::make($request->all(), [
            'file_to_upload' => 'required|file|mimes:pdf|max:' . config('print.pdf_size_limit'),
            'number_of_copies' => 'required|integer|min:1'
        ]);
        $validator->validate();

        $print_account = Auth::user()->printAccount;
        $is_two_sided = $request->has('two_sided');
        $file = $request->file_to_upload;
        $number_of_copies = $request->number_of_copies;
        $pages = $this->getPages($validator, $file->getPathName());
        $use_free_pages = $request->use_free_pages;

        if ($validator->fails()) {
            return back()->withErros($validator)->withInput();
        }
        // Only calculating the values here to see how many pages can be covered free of charge.
        $free_page_pool = [];
        if ($use_free_pages) {
            $available_pages = 0;
            $all_pages = Auth::user()->freePages
                ->where('deadline', '>', \Carbon\Carbon::now())
                ->sortBy('deadline');
            foreach ($all_pages as $key => $free_page) {
                if ($available_pages + $free_page->amount >= $pages) {
                    $free_page_pool[] = [
                        'page' => $free_page,
                        'new_amount' => $free_page->amount - ($pages - $available_pages)
                    ];
                    $available_pages = $pages;
                    break;
                }
                $free_page_pool[] = [
                    'page' => $free_page,
                    'new_amount' => 0
                ];
                $available_pages += $free_page->amount;
            }
            $pages -= $available_pages;
        }

        $cost = PrintAccount::getCost($pages, $is_two_sided, $number_of_copies);

        if (!$print_account->hasEnoughMoney($cost)) {
            return $this->handleNoBalance($validator);
        }
        if ($this->printFile($file, $cost, $is_two_sided, $number_of_copies)) {
            $print_account->update(['last_modified_by' => Auth::user()->id]);
            foreach ($free_page_pool as $fp) {
                $fp['page']->update([
                    'amount' => $fp['new_amount'],
                    'last_modified_by' => Auth::user()->id
                ]);
            }
            $print_account->decrement('balance', $cost);
            return back()->with('message', __('print.success'));
        } else {
            return back()->withErrors(['print' => __('print.error_printing')]);
        }
    }

    public function transferBalance(Request $request) {
        $validator = Validator::make($request->all(), [
            'balance' => 'required|integer|min:1',
            'user_to_send' => 'required|integer|exists:users,id'
        ]);
        $validator->validate();
        
        if ($validator->fails()) {
            return back()->withErros($validator)->withInput();
        }

        $balance = $request->balance;
        $from_account = Auth::user()->printAccount;
        $to_account = User::find($request->user_to_send)->printAccount;

        if (!$from_account->hasEnoughMoney($balance)) {
            return $this->handleNoBalance($validator);
        }
        $to_account->update(['last_modified_by' => Auth::user()->id]);
        $from_account->update(['last_modified_by' => Auth::user()->id]);

        $from_account->decrement('balance', $balance);
        $to_account->increment('balance', $balance);

        return redirect()->route('print');
    }

    public function modifyBalance(Request $request) {
        $validator = Validator::make($request->all(), [
            'user_id_modify' => 'required|integer|exists:users,id',
            'balance' => 'required|integer',
        ]);
        $validator->validate();

        $balance = $request->balance;
        $print_account = User::find($request->user_id_modify)->printAccount;

        if ($balance < 0 && !$print_account->hasEnoughMoney($balance)) {
            return $this->handleNoBalance($validator);
        }
        $print_account->update(['last_modified_by' => Auth::user()->id]);
        $print_account->increment('balance', $balance);
        return redirect()->back();
    }

    public function addFreePages(Request $request) {
        $validator = Validator::make($request->all(), [
            'user_id_free' => 'required|integer|exists:users,id',
            'free_pages' => 'required|integer|min:1',
            'deadline' => 'required|date|after:now',
        ]);
        $validator->validate();

        $free_pages = $request->free_pages;

        FreePages::create([
            'user_id' => $request->user_id_free,
            'amount' => $request->free_pages,
            'deadline' => $request->deadline,
            'last_modified_by' => Auth::user()->id,
            'comment' => $request->comment,
        ]);

        return redirect()->back();
    }

    public function listPrintJobs() {
        $this->authorize('viewAny', PrintJob::class);
        $this->updateCompletedPrintingJobs();

        $columns = ['created_at', 'filename', 'cost', 'state'];
        if (Auth::user()->hasRole(\App\Role::PRINT_ADMIN)) {
            array_push($columns, 'user.name');
            $paginator = TabulatorPaginator::from(
                    PrintJob::join('users as user', 'user.id', '=', 'user_id')
                            ->select('print_jobs.*')
                            ->with('user')
                            ->orderby('print_jobs.created_at', 'desc')
                )->sortable($columns)->filterable($columns)->paginate();
        } else {
            $paginator = TabulatorPaginator::from(Auth::user()->printJobs()->orderby('created_at', 'desc'))
                ->sortable($columns)->filterable($columns)->paginate();
        }

        $paginator->getCollection()->transform(PrintJob::translateStates());
        $paginator->getCollection()->transform(PrintJob::addCurrencyTag());
        return $paginator;
    }

    public function listFreePages() {
        $this->authorize('viewAny', FreePages::class);

        $columns = ['amount', 'deadline', 'modifier', 'comment'];
        if (Auth::user()->hasRole(\App\Role::PRINT_ADMIN)) {
            array_push($columns, 'user.name');
            array_push($columns, 'created_at');
            $paginator = TabulatorPaginator::from(
                    FreePages::join('users as user', 'user.id', '=', 'user_id')
                        ->join('users as creator', 'creator.id', '=', 'last_modified_by')
                        ->select('creator.name as modifier', 'printing_free_pages.*')
                        ->with('user')
                )->sortable($columns)
                ->filterable($columns)
                ->paginate();
        } else {
            $paginator = TabulatorPaginator::from(
                    Auth::user()->freePages()
                        ->join('users as creator', 'creator.id', '=', 'last_modified_by')
                        ->select('creator.name as modifier', 'printing_free_pages.*')
                        ->with('user')
                )->sortable($columns)
                ->filterable($columns)
                ->paginate();
        }

        return $paginator;
    }

    public function listPrintAccountHistory() {
        $this->authorize('viewAny', PrintJob::class);
        
        $columns = ['user.name', 'balance_change', 'free_page_change', 'deadline_change', 'modifier', 'modified_at'];
        $paginator = TabulatorPaginator::from(
            PrintAccountHistory::join('users as user', 'user.id', '=', 'user_id')
                    ->join('users as modifier', 'modifier.id', '=', 'modified_by')
                    ->select('print_account_history.*', 'modifier.name as modifier')
                    ->with('user')
            )->sortable($columns)
            ->filterable($columns)
            ->paginate(); 
        return $paginator; 
    }

    public function cancelPrintJob($id) {
        //TODO: actually cancel
        $printJob = PrintJob::findOrFail($id);

        $this->authorize('update', $printJob);

        if ($printJob->state === PrintJob::QUEUED) $printJob->update(['state' => PrintJob::CANCELLED]);
    }

    private function updateCompletedPrintingJobs() {
        $result = Commands::updateCompletedPrintingJobs();
        Log::info("Completed jobs: " . implode(', ', $result));
        PrintJob::whereIn('job_id', $result)->update(['state' => PrintJob::SUCCESS]);
    }

    private function printFile($file, $cost, $is_two_sided, $number_of_copies) {
        $printer_name = config('print.printer_name');
        $state = PrintJob::QUEUED;
        try {
            $path = $file->storeAs('', md5(rand(0, 100000) . date('c')) . '.pdf', 'printing');
            $path = Storage::disk('printing')->getDriver()->getAdapter()->applyPathPrefix($path);
            $command = "lp -d " . $printer_name
                    . ($is_two_sided ? " -o sides=two-sided-long-edge " : " ")
                    . "-n " . $number_of_copies . " "
                    . $path . " 2>&1";
            Log::info($command);
            $result = Commands::print($command);
            if (!preg_match("/^request id is ([^\s]*) \\([0-9]* file\\(s\\)\\)$/", $result, $job)) {
                Log::error("Printing error at line: " . __FILE__ . ":" . __LINE__ . " (in function " . __FUNCTION__ . "). result:"
                    . print_r($result, true));
                $state = PrintJob::ERROR;
            }
            $job_id = $job[1];
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

        return back()->with('error',  __('print.no_balance'));
    
    }

    private function getPages($validator, $path) {
        $pages = Commands::getPages($path);

        if ($pages == "" || !is_numeric($pages) || $pages <= 0) {
            Log::error("Cannot get number of pages for uploaded file!" . print_r($pages, true));
            $validator->errors()->add('file_to_upload', __('print.invalid_pdf'));
        }
        return $pages;
    }


}
