<?php

namespace Database\Seeders;

use App\Models\EpistolaNews;
use Illuminate\Database\Seeder;

class EpistolaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        EpistolaNews::factory()->count(5)->create();
    }
}
