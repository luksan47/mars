<?php

namespace App\Console\Commands;

use App\Models\Semester;
use App\Models\WorkshopBalance;
use Illuminate\Console\Command;

class RecalculateWorkshopBalances extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'workshopbalance:recalculate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Recalculate Workshop Balances';

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
        $semesters = Semester::all()
            ->where('tag', '<=', Semester::current()->tag);
        foreach ($semesters as $semester) {
            WorkshopBalance::generateBalances($semester->id);
        }
    }
}
