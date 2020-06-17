<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Course;
use Faker\Generator as Faker;

$factory->define(App\Course::class, function (Faker $faker) {
    return [
        'code' => $faker->slug,
        'workshop_id' => \App\Workshop::find(1)->id, //TODO: $faker->
        'name' => $faker->catchPhrase,
        'name_english' => $faker->bs,
        'type' => $faker->randomElement(Course::TYPES),
        'credits' => $faker->randomDigit,
        'hours' => $faker->numberBetween(1, 3),
        'semester_id' => \App\Semester::find(1)->id, //TODO: $faker->
        'teacher_id' => \App\Semester::find(1)->id, //TODO: $faker->
        'updated_at' => now(),
        'created_at' => now(),
    ];
});
