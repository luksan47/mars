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
        $semester = Semester::firstOrCreate([
            'year' => 2015,
            'part' => 1,
        ]);

        while ($semester != Semester::next()) {
            // This creates the semester if it does not exists
            $semester = $semester->succ();
        }

        $users = User::collegists();

        $semesters = Semester::all()->unique();
        foreach ($semesters as $semester) {
            foreach ($users as $user) {
                $status = array_rand(Semester::STATUSES);
                $user->setStatusFor($semester, Semester::STATUSES[$status]);
            }
        }
    }
}
