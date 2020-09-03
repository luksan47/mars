<?php

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
        factory(App\Router::class, 5)->create();
        factory(App\Router::class, 15)->create(['failed_for' => 0]);
    }
}
