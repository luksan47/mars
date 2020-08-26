<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

require_once base_path('app/Console/Commands/Helpers/GenerateLanguageFile.php');

class MigrateTranslations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'locale:migrate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add existing translations (except hu, en files) to the localization_contribution table. Used after merging PR #271.';

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
        $languages = array_diff(scandir(base_path('resources/lang/')), ['..', '.', 'hu', 'en']);
        foreach ($languages as $language) {
            $files = array_diff(scandir(base_path('resources/lang/'.$language)), ['..', '.', 'validation.php']);
            foreach ($files as $file) {
                $expressions = require base_path('resources/lang/'.$language.'/'.$file);
                $filename = substr($file, 0, (strlen ($file) - 4 ));
                foreach ($expressions as $key => $value) {
                    if(is_string($value)){
                        DB::table('localization_contributions')->insert([
                            'language' => $language,
                            'key' => $filename.'.'.$key,
                            'value' => $value,
                            'contributor_id' => null,
                            'approved' => false,
                        ]);
                    }
                }
            }
        }
    }
}
