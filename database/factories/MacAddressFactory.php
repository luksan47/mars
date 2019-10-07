<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\MacAddress;
use Faker\Generator as Faker;

$factory->define(App\MacAddress::class, function (Faker $faker) {
    return [
        'mac_address' => $faker->macAddress,
        'comment' => $faker->text,
        'state' => $faker->randomElement(['REQUESTED', 'APPROVED', 'REJECTED'])
    ];
});
