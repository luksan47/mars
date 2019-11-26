<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
        $validator = Validator::make($request->all(), [
            'file_to_upload' => 'required|file|mimes:pdf|max:120000',
            'number_of_copies' => 'required|integer|min:1'
        ]);
        $validator->validate();

        $print_account = Auth::user()->printAccount;
        $is_two_sided = $request->has('two_sided');
        $file = $request->file_to_upload;
        $pages = $this->getPages($validator, $file->getPathName());

        if ($validator->fails()) {
            return back()->withErros($validator)->withInput();
        }

        $cost = PrintAccount::getCost($pages, $is_two_sided);

        if (!$print_account->hasEnoughMoney($cost)) {
            return $this->handleNoBalance($validator);
        }

        if ($this->printFile($file, $cost, $is_two_sided, $request->number_of_copies)) {
            $print_account->decrement('balance', $cost);
            return back()->with('print.status', __('print.success'));
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
            $validator->errors()->add('$free_pages', __('print.no_free_pages_left'));
            return back()
                ->withErrors($validator)
                ->withInput();
        }
        $print_account->increment('free_pages', $free_pages);
        return redirect()->route('print');
    }

    public function listPrintJobs() {
        $this->authorize('viewAny', PrintJob::class);
        $this->updateCompletedPrintingJobs();

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

    public function cancelPrintJob($id) {
        //TODO: actually cancel
        $printJob = PrintJob::findOrFail($id);

        $this->authorize('update', $printJob);
        
        if ($printJob->state === PrintJob::QUEUED) $printJob->update(['state' => "CANCELLED"]);
    }
    
    private function updateCompletedPrintingJobs() {
        if (!config('app.debug')) {
            exec("lpstat -W completed -o " . env('PRINTER_NAME') . " | awk '{print $1}'", $result);
            PrintJob::whereIn('job_id', $result)->update(['state' => "CANCELLED"]);
        }
    }

    private function printFile($file, $cost, $is_two_sided, $number_of_copies) {
        $printer_name = config('app.printer_name');
        $state = "QUEUED";
        try {
            $path = $file->storeAs('', md5(rand(0, 100000) . date('c')) . '.pdf', 'printing');
            $path = Storage::disk('printing')->getDriver()->getAdapter()->applyPathPrefix($path);
            $result = exec("lp -d " . $printer_name
                . ($is_two_sided ? " -o sides=two-sided-long-edge " : " ")
                . "-n " . $number_of_copies . " "
                . $path . " 2>&1");
            if (!preg_match("/^request id is ([^\s]*) \\(?<id> file\\(s\\)\\)$/", $result, $job)) {
                Log::error("Printing error at line: " . __FILE__ . ":" . __LINE__ . " (in function " . __FUNCTION__ . "). result:"
                    . print_r($result, true));
                $state = "ERROR";
            }
            $job_id = $job['id'];
        } catch (\Exception $e) {
            Log::error("Printing error at line: " . __FILE__ . ":" . __LINE__ . " (in function " . __FUNCTION__ . "). " . $e->getMessage());
            $state = "ERROR";
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
        return $state == "QUEUED";
    }

    private function handleNoalance($validator) {
        $validator->errors()->add('balance', __('print.nobalance'));
        return back()
            ->withErrors($validator)
            ->withInput();
    }

    private function getPages($validator, $path) {
        $pages = exec("pdfinfo " . $path . " | grep '^Pages' | awk '{print $2}' 2>&1");

        if ($pages == "" || !is_numeric($pages) || $pages <= 0) {
            Log::error("Cannot get number of pages for uploaded file!" . print_r($pages, true));
            $validator->errors()->add('file_to_upload', __('print.invalid_pdf'));
        }
        return $pages;
    }
}
