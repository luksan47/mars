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
                            {language? : the language to add eg. en} 
                            {key? : the key of the expression eg. general.home} 
                            {value? : the localized value of the expression} 
                            {--F|force : Whether the arguments are provided and the action can be automated. If not, the arguments are prompted from the user.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add an expression to the language files.';

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
        if ($this->option('force')) {
            //set expression based on arguments
            $language = $this->argument('language');
            $key = $this->argument('key');
            $expression_value = $this->argument('value');
            if ($key == null || $language == null || $expression_value == null) {
                $this->error('Missing argument(s).');

                return 1;
            }
            if (count(explode('.', $key)) != 2) {
                $this->error('Invalid key format.');

                return 1;
            }

            $file = explode('.', $key)[0];
            $expression_key = explode('.', $key)[1];

            $path = '/resources/lang/'.$language.'/'.$file.'.php';
            $expressions = file_exists(base_path($path)) ? require base_path($path) : [];

            $expressions[$expression_key] = $expression_value;
            if (! (ksort($expressions))) {
                $this->error('Sorting '.$file_in.' failed.');

                return 1;
            }
            if (! is_dir(base_path('/resources/lang/'.$language))) {
                mkdir(base_path('/resources/lang/'.$language), 0755, true); // create folders if needed
            }
            $file_write = fopen(base_path($path), 'w');
            if (! (generate_file($file_write, $expressions))) {
                $this->error('Writing to '.$file.' failed.');

                return 1;
            }
            $this->comment('Set '.$expression_key.' to '.$expression_value.'.');
        } else {
            //set hungarian and english translation manually
            $key = $this->ask('What should be the key of the expression (eg. general.home)?');
            if (count(explode('.', $key)) != 2) {
                $this->error('Invalid key format.');

                return 1;
            }
            $file = explode('.', $key)[0];
            $expression_key = explode('.', $key)[1];

            foreach (['en', 'hu'] as $language) {
                $path = '/resources/lang/'.$language.'/'.$file.'.php';
                if (! file_exists(base_path($path))) {
                    if (! $this->confirm('Do you want to create a new '.($language == 'en' ? 'english' : 'hungarian').' file named '.$file.'.php?')) {
                        $this->info('Action cancelled.');

                        return;
                    }
                }
                $expressions = file_exists(base_path($path)) ? require base_path($path) : [];
                if (isset($expressions[$expression_key])) {
                    if (! $this->confirm('Do you want to override the old '.($language == 'en' ? 'english' : 'hungarian').' translation ('.$expressions[$expression_key].')?')) {
                        $this->info('Action cancelled.');

                        return;
                    }
                }

                //save expression
                $expression_value = $this->ask('What should be the '.($language == 'en' ? 'english' : 'hungarian').' translation?');
                $expressions[$expression_key] = $expression_value;
                if (! (ksort($expressions))) {
                    $this->error('Sorting the '.($language == 'en' ? 'english' : 'hungarian').' '.$file.' failed.');

                    return 1;
                }
                $file_write = fopen(base_path($path), 'w');
                if (! (generate_file($file_write, $expressions))) {
                    $this->error('Writing to the '.($language == 'en' ? 'english' : 'hungarian').' '.$file.' failed.');

                    return 1;
                }
                $this->comment('Set '.($language == 'en' ? 'english' : 'hungarian').' '.$expression_key.' to '.$expression_value.'.');
            }
        }
    }
}
