<?php

use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Course::class, 90)->create()->each(function ($course) {
            $faker = Faker\Factory::create();
            $time = $faker->dateTimeBetween('-1 week', '+ 1 week');
            $dt = \Carbon\Carbon::instance($time);
            $midDay = \Carbon\Carbon::instance($dt)->midDay();
            if ($dt < $midDay)
            {
                $dt = $dt->addHours(12);
            }
            $course->classrooms()->attach(
                App\Classroom::all()->random(),
                ['time' => $dt]
            );
        });
    }
}
