<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Semester;
use Faker\Generator as Faker;

$factory->define(Semester::class, function (Faker $faker) {
    return [
        'year' => $faker->numberBetween(2020, 2030),
        'part' => $faker->randomElements(Semester::PARTS),
    ];
});
