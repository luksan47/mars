<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Router;
use Faker\Generator as Faker;

$factory->define(Router::class, function (Faker $faker) {
    return [
        'ip' => $faker->unique()->ipv4,
        'room' => $faker->unique()->numberBetween(200, 400),
        'failed_for' => $faker->numberBetween(0, 100),
    ];
});
