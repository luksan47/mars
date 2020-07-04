<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\PersonalInformation;
use Faker\Generator as Faker;

$factory->define(PersonalInformation::class, function (Faker $faker) {
    return [
        'place_of_birth' => $faker->city,
        'date_of_birth' =>$faker->date($format = 'Y-m-d', $max = 'now'),
        'mothers_name' => $faker->name($gender = 'female'),
        'phone_number' => $faker->numerify('+36 (##) ###-####'),
        'country' => $faker->country,
        'county' => $faker->state,
        'zip_code' => $faker->postcode,
        'city' => $faker->city,
        'street_and_number' => $faker->streetAddress,
    ];
});
