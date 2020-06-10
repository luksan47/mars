<?php

use Illuminate\Database\Seeder;

class CamelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
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
