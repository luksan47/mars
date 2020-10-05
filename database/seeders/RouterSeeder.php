<?php

namespace Database\Seeders;

use App\Router;
use Illuminate\Database\Seeder;

class RouterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Router::factory()->count(5)->create();
        Router::factory()->count(15)->create(['failed_for' => 0]);
    }
}
