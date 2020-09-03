<?php

namespace App\Jobs;

use App\Console\Commands;
use App\Router;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class PingRouter implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $router;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $result = Commands::pingRouter($this->router);
        if ($result == '') {
            $this->router->update([
                'failed_for' => 0,
            ]);
        } else {
            $this->router->increment('failed_for');
        }
    }
}
