<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

require_once base_path('app/Console/Commands/Helpers/GenerateLanguageFile.php');

class AddExpression extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'locale:add 
                            {language : the language to add eg. en} 
                            {key : the key of the expression eg. general.home} 
                            {value : the localized value of the expression} 
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
        $file = explode('.', $this->argument('key'))[0];
        $expression_key = explode('.', $this->argument('key'))[1];
        $expression_value = $this->argument('value');
        $reviewed = $this->option('force');
        $path = 'resources/lang/'.$language.'/'.$file.'.php';
        $expressions = file_exists($path) ? require base_path($path) : [];
        if (! ($reviewed)) {
            if (isset($expressions[$expression_key])) {
                if ($this->confirm('Do you want to override '.$expressions[$expression_key].' to '.$expression_value.'?')) {
                    $reviewed = true;
                }
            } else {
                if ($this->confirm('Do you want to set '.$expression_key.' as '.$expression_value.'?')) {
                    $reviewed = true;
                }
            }
        }
        if ($reviewed) {
            $expressions[$expression_key] = $expression_value;
            if (! (ksort($expressions))) {
                $this->error('Sorting '.$file_in.' failed.');
            }
            $file_write = fopen(base_path($path), 'w');
            if (! (generate_file($file_write, $expressions))) {
                $this->error('Writing to '.$file.' failed.');
            }
            $this->comment('Set '.$expression_key.' to '.$expression_value.'.');
        } else {
            $this->comment('Nothing changed.');
        }
    }
}
