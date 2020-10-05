<?php

namespace App\Http\Controllers;

use App\Console\Commands;
use App\User;
use App\PrintAccount;
use App\FreePages;
use App\PrintJob;
use App\PrintAccountHistory;
use App\Utils\Printer;
use App\Utils\TabulatorPaginator;
use App\Transaction;
use App\Checkout;
use App\Semester;
use App\PaymentType;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
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

        if ($validator->fails()) {
            return back()->withErros($validator)->withInput();
        }

        $is_two_sided = $request->has('two_sided');
        $number_of_copies = $request->number_of_copies;
        $use_free_pages = $request->use_free_pages;
        $file = $request->file_to_upload;
        $filename = $file->getClientOriginalName();
        $path = $this->storeFile($file);

        $printer = new Printer($filename, $path, $use_free_pages, $is_two_sided, $number_of_copies);

        return $printer->print();
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
        $user = User::find($request->user_to_send);
        $from_account = Auth::user()->printAccount;
        $to_account = $user->printAccount;

        if (!$from_account->hasEnoughMoney($balance)) {
            return $this->handleNoBalance();
        }
        $to_account->update(['last_modified_by' => Auth::user()->id]);
        $from_account->update(['last_modified_by' => Auth::user()->id]);

        $from_account->decrement('balance', $balance);
        $to_account->increment('balance', $balance);

        // Send notification mail
        if (config('mail.active')) {
            Mail::to($user)->queue(new \App\Mail\ChangedPrintBalance($user, $balance, Auth::user()->name));
        }

        return redirect()->back()->with('message', __('general.successful_transaction'));
    }

    public function modifyBalance(Request $request) {
        $validator = Validator::make($request->all(), [
            'user_id_modify' => 'required|integer|exists:users,id',
            'balance' => 'required|integer',
        ]);
        $validator->validate();

        $balance = $request->balance;
        $user = User::find($request->user_id_modify);
        $print_account = $user->printAccount;

        if ($balance < 0 && !$print_account->hasEnoughMoney($balance)) {
            return $this->handleNoBalance();
        }
        $print_account->update(['last_modified_by' => Auth::user()->id]);
        $print_account->increment('balance', $balance);

        $admin_checkout = Checkout::where('name', 'ADMIN')->firstOrFail();
        Transaction::create([
            'checkout_id' => $admin_checkout->id,
            'receiver_id' => Auth::user()->id,
            'payer_id' => $user->id,
            'semester_id' => Semester::current()->id,
            'amount' => $request->balance,
            'payment_type_id' => PaymentType::print()->id,
            'comment' => null,
            'moved_to_checkout' => null,
        ]);

        // Send notification mail
        if (config('mail.active')) {
            Mail::to($user)->queue(new \App\Mail\ChangedPrintBalance($user, $balance, Auth::user()->name));
        }

        return redirect()->back()->with('message', __('general.successful_modification'));
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

        return redirect()->back()->with('message', __('general.successfully_added'));
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

    /** Private helper functions */

    private function updateCompletedPrintingJobs() {
        try {
            $result = Commands::updateCompletedPrintingJobs();
            PrintJob::whereIn('job_id', $result)->update(['state' => PrintJob::SUCCESS]);
        } catch (\Exception $e) {
            Log::error("Printing error at line: " . __FILE__ . ":" . __LINE__ . " (in function " . __FUNCTION__ . "). " . $e->getMessage());
        }
    }

    private function storeFile($file)
    {
        $path = $file->storeAs('', md5(rand(0, 100000) . date('c')) . '.pdf', 'printing');
        $path = Storage::disk('printing')->getDriver()->getAdapter()->applyPathPrefix($path);
        return $path;
    }

    private function handleNoBalance() {
        return back()->withInput()->with('error',  __('print.no_balance'));
    }
}
