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

class PrintController extends Controller
{
    public function index() {
        return view('print.app');
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
        $pages = $this->get_pages($validator);

        if ($validator->fails()) {
            return back()-withErros($validator)->withInput();
        }

        $cost = PrintAccount::getCost($pages, $is_two_sided);

        if (!$print_account->hasEnoughMoney($cost)) {
            return $this->handle_no_balance($validator);
        }

        if ($this->print_file($file, $cost, $is_two_sided, $request->number_of_copies)) {
            $print_account->decrement('balance', $cost);
            return back()->with('print.status', __('print.success'));
        } else {
            return back()->withErrors(['print' => __('print.error_printing')]);
        }
    }

    public function modify_balance(Request $request) {
        $balance = $request->balance;
        $print_account = User::findOrFail($request->user_id)->printAccount; 
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer|exists:users,id',
            'balance' => 'required|integer',
        ]);
        $validator->validate();

        if ($balance < 0) {
            $balance = abs($balance);
            if (!$print_account->hasEnoughMoney($balance)) {
                return $this->handle_no_balance($validator);
            } else {
                $print_account->decrement('balance', $balance);
            }
        } else {
            $print_account->increment('balance', $balance);
        }
        return redirect()->route('print');
    }

    private function print_file($file, $cost, $is_two_sided, $number_of_copies) {
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
                Log::error("Printing error at line: ".__FILE__.":".__LINE__." (in function ".__FUNCTION__."). result:"
                    . print_r($result, true));
                $state = "ERROR";
            }
            $job_id = $job['id'];
        }
        catch (\Exception $e){
            Log::error("Printing error at line: ".__FILE__.":".__LINE__." (in function ".__FUNCTION__."). ". $e->getMessage());
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

    private function handle_no_balance($validator) {
        $validator->errors()->add('balance', __('print.nobalance'));
        return back()
                ->withErrors($validator)
                ->withInput();
    }

    private function get_pages($validator) {
        $pages = exec("pdfinfo " . $file->getPathName() . " | grep '^Pages' | awk '{print $2}' 2>&1");

        if ($pages == "" || !is_numeric($pages) || $pages <= 0) {
            Log::error("Cannot get number of pages for uploaded file!" . print_r($pages, true));
            $validator->errors()->add('file_to_upload', __('internet.invalid_pdf'));
        }
        return $pages;
    }
}
