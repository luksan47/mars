<?php

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
        $semester = \App\Semester::create([
            'year' => 2019,
            'part' => 2
        ]);

        $users = \App\User::all();

        //TODO: this could be more random
        foreach ($users as $key => $user) {
            $user->allSemesters()->attach($semester, ['status' => \App\Semester::ACTIVE]);
        }
    }
}
