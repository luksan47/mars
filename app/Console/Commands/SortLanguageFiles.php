<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
require_once base_path('app/Console/Commands/Helpers/GenerateLanguageFile.php');

class SortLanguageFiles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'locale:sort';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sort language expressions';

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
        $languages = array_diff(scandir(base_path('resources/lang/')), ['..', '.']);
        foreach ($languages as $language) {
            $files = array_diff(scandir(base_path('resources/lang/'.$language)), ['..', '.']);
            foreach ($files as $file_in) {
                $expressions = require base_path('resources/lang/'.$language.'/'.$file_in);
                if (! (ksort($expressions))) {
                    $this->error('Sorting '.$file_in.' failed.');
                }
                $file_out = fopen(base_path('resources/lang/'.$language.'/'.$file_in), 'w');
                if (! (generate_file($file_out, $expressions))) {
                    $this->error('Writing to '.$file_in.' failed.');
                }
            }
        }
        $this->comment("Expressions sorted succesfully");
    }
}
