<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\EducationalInformation;
use Faker\Generator as Faker;

$factory->define(EducationalInformation::class, function (Faker $faker) {
    return [
        'year_of_graduation' => $faker->numberBetween($min = 1895, $max = date('Y')),
        'high_school' => $faker->company,
        'neptun' => $faker->regexify('[A-Z0-9]{6}'),
        'year_of_acceptance' => $faker->numberBetween($min = 1895, $max = date('Y')),
    ];
});
