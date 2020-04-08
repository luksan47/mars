<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);

        DB::table('shepherds')->insert([
            'id' => 0,
            'name' => 'Vendég',
            'camels' => null,
            'min_camels' => null,
        ]);
        DB::table('farmer')->insert([
            'password' => bcrypt('asdasdasd'),
            'def_min_camels' => -500,
        ]);
    }
}
