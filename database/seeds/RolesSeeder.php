<?php

use Illuminate\Database\Seeder;
use App\Role;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
            'name' => 'admin'
        ]);
        Role::create([
            'name' => 'collegist'
        ]);
        Role::create([
            'name' => 'tenant'
        ]);
        Role::create([
            'name' => 'workshop-administrator'
        ]);
    }
}
