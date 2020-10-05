<?php

namespace App\Utils;

use App\Models\PrintAccount;
use App\Models\PrintJob;
use App\Console\Commands;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class Printer
{
    private $filename;
    private $path;
    private $pages = 0;
    private $is_two_sided;
    private $number_of_copies;
    private $use_free_pages;
    private $print_account;
    private $free_page_pool = [];
    private $cost = 0;

    public function __construct($filename, $path, $use_free_pages = false, $is_two_sided = true, $number_of_copies = 1)
    {
        $this->filename = $filename;
        $this->path = $path;
        $this->is_two_sided = $is_two_sided;
        $this->number_of_copies = $number_of_copies;
        $this->use_free_pages = $use_free_pages;
        $this->print_account = Auth::user()->printAccount;
    }

    public function print()
    {
        // Getting the number of pages from the document
        $errors = $this->setPages();
        if($errors !=  null) {
            return $errors;
        }

        // If using free pages, check the amount that can be used
        if ($this->use_free_pages) {
            $this->calculateFreePagePool();
        }

        // Calculate cost
        $this->cost = PrintAccount::getCost($this->pages, $this->is_two_sided, $this->number_of_copies);

        // Check balance
        if (!$this->print_account->hasEnoughMoney($this->cost)) {
            return back()->withInput()->with('error',  __('print.no_balance'));
        }

        // Print document
        return $this->printDocument();
    }

    /**
     * Only calculating the values here to see how many pages can be covered free of charge.
     */
    private function calculateFreePagePool()
    {
        $this->free_page_pool = [];
        $available_pages = 0;
        $all_pages = Auth::user()->freePages
            ->where('deadline', '>', Carbon::now())
            ->sortBy('deadline');

        foreach ($all_pages as $key => $free_page) {
            if ($available_pages + $free_page->amount >= $this->pages) {
                $this->free_page_pool[] = [
                    'page' => $free_page,
                    'new_amount' => $free_page->amount - ($this->pages - $available_pages)
                ];
                $available_pages = $this->pages;
                break;
            }
            $this->free_page_pool[] = [
                'page' => $free_page,
                'new_amount' => 0
            ];
            $available_pages += $free_page->amount;
        }

        $this->pages -= $available_pages;
    }

    private function printDocument()
    {
        // Print file and return on error
        if (!$this->printFile()) {
            return back()->with('error', __('print.error_printing'));
        }

        // Update print account history
        $this->print_account->update(['last_modified_by' => Auth::user()->id]);
        foreach ($this->free_page_pool as $fp) {
            $fp['page']->update([
                'amount' => $fp['new_amount'],
                'last_modified_by' => Auth::user()->id
            ]);
        }

        // Update print account
        $this->print_account->decrement('balance', $this->cost);

        return back()->with('message', __('print.success'));
    }

    private function printFile() {
        $printer_name = config('print.printer_name');
        $state = PrintJob::QUEUED;
        try {
            $command = "lp -d " . $printer_name
                    . ($this->is_two_sided ? " -o sides=two-sided-long-edge " : " ")
                    . "-n " . $this->number_of_copies . " "
                    . $this->path . " 2>&1";
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
            $this->path = "";
        }

        PrintJob::create([
            'filename' => $this->filename,
            'filepath' => $this->path,
            'user_id' => Auth::user()->id,
            'state' => $state,
            'job_id' => $job_id,
            'cost' => $this->cost,
        ]);
        return $state == PrintJob::QUEUED;
    }

    private function setPages()
    {
        try {
            $this->pages = Commands::getPages($this->path);
        } catch (\Exception $e) {
            Log::error("File retrieval exception at line: " . __FILE__ . ":" . __LINE__ . " (in function " . __FUNCTION__ . "). " . $e->getMessage());
            $this->pages = "";
        }

        if ($this->pages == "" || !is_numeric($this->pages) || $this->pages <= 0) {
            Log::error("Cannot get number of pages for uploaded file!" . print_r($this->pages, true));
            return back()->withInput()->with('error', __('print.invalid_pdf'));
        }
        return null;
    }
}
