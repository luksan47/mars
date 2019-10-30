<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\PrintJob;
use Faker\Generator as Faker;

$factory->define(PrintJob::class, function (Faker $faker) {
    return [
        'filename' => $faker->text,
        'filepath' => $faker->text,
        'state' => $faker->randomElement(PrintJob::STATES),
        'job_id' => $faker->randomNumber,
        'cost' => $faker->numberBetween(8, 1000),
    ];
});
