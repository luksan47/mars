<?php

namespace Database\Seeders;

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
        $this->call(SemesterSeeder::class);
        $this->call(RouterSeeder::class);
<<<<<<< HEAD
        $this->call(TransactionSeeder::class);
=======
        $this->call(EpistolaSeeder::class);
>>>>>>> aff6238... View, improved properties
    }
}
