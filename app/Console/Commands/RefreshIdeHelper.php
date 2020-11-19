<?php

namespace App\Console\Commands;

use Artisan;
use Illuminate\Console\Command;

class RefreshIdeHelper extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ide-helper:refresh';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Refresh ide helper';

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
     * @return int
     */
    public function handle()
    {
        Artisan::call('ide-helper:generate');
        Artisan::call('ide-helper:meta');
        Artisan::call('ide-helper:models --nowrite');
        Artisan::call('ide-helper:eloquent');
    }
}
