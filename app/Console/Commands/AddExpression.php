<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class AddExpression extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'language:add 
                            {language : the language to add eg. en} 
                            {file : the file to add eg. general} 
                            {expression_key : the english key of the expression} 
                            {expression_value : the localized value of the expression} 
                            {--F|force : Whether confirmation is required to overwrite values}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add an expression to a language file';

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
        $language = $this->argument('language');
        $file = $this->argument('file');
        $expression_key = $this->argument('expression_key');
        $expression_value = $this->argument('expression_value');
        $reviewed = $this->option('force');
        $expressions = require base_path('resources/lang/'.$language.'/'.$file.'.php');
        if(!($reviewed)){
            if(isset($expressions[$expression_key])){
                if ($this->confirm('Do you want to override '.$expressions[$expression_key].' to '.$expression_value.'?')) {
                    $reviewed = true;
                }
            } else {
                if ($this->confirm('Do you want to set '.$expression_key.' as '.$expression_value.'?')) {
                    $reviewed = true;
                }
            }
        }
        if($reviewed){
            $expressions[$expression_key] = $expression_value;
            if(!(ksort($expressions))){
                $this->error('Sorting '.$file_in.' failed.');
            }
            $file_write = fopen(base_path('resources/lang/'.$language.'/'.$file.'.php'), "w");
            if(!(fwrite($file_write, "<?php\n\nreturn ".var_export($expressions, true).";"))){
                $this->error('Writing to '.$file.' failed.');
            };
            $this->line('Set '.$expression_key.' to '. $expression_value.'.');
        } else {
            $this->comment('Nothing changed.');
        }
    }
}
