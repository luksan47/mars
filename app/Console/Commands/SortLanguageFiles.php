<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SortLanguageFiles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'language:sort';

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
        $languages = array_diff(scandir(base_path('resources/lang/')), array('..', '.'));
        foreach ($languages as $language) {
            $files = array_diff(scandir(base_path('resources/lang/'.$language)), array('..', '.'));
            foreach ($files as $file_in){
                $expressions = require base_path('resources/lang/'.$language.'/'.$file_in);
                if(!(ksort($expressions))){
                    $this->error('Sorting '.$file_in.' failed.');
                }
                $file_out = fopen(base_path('resources/lang/'.$language.'/'.$file_in), "w");
                if(!(fwrite($file_out, "<?php\n\nreturn ".var_export($expressions, true).";"))){
                    $this->error('Writing to '.$file_in.' failed.');
                };
            }
        }
    }
}