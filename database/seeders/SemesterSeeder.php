<?php

namespace Database\Seeders;

use App\Models\Semester;
use App\Models\User;
use Illuminate\Database\Seeder;

class SemesterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // TODO: there could be more semesters
        $semester = Semester::create([
            'year' => 2019,
            'part' => 2,
        ]);

        $users = User::all();

        //TODO: this could be more random
        foreach ($users as $key => $user) {
            $user->allSemesters()->attach($semester, ['status' => Semester::ACTIVE]);
        }
    }
}
