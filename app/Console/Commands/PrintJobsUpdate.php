<?php

namespace App\Console\Commands;


use App\PrintJob;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class PrintJobsUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'printjobs:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update the state of print jobs in the database by querying the print queue';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        
        if (config('printing.enabled')) {
            $output = exec(
                sprintf("lpstat %s -W not-completed -o '%s' | awk '{print $1}'",
                    config('printing.utility_args'),
                    config('printing.printer_name')),
                $result,
                $exit_code
            );
            
            if ($exit_code == 0) {
                PrintJob::where('state', PrintJob::QUEUED)
                    ->whereNotIn('job_id', $result)
                    ->update(['state' => PrintJob::COMPLETED]);
            } else {
                Log::error(
                    sprintf("PrintJobsUpdate::handle(): could not query print jobs: exit_code=%d, output='%s'",
                        $exit_code,
                        $output
                ));
            }
        }
    }
}
