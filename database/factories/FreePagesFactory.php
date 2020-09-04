<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\FreePages;
use Faker\Generator as Faker;

$factory->define(FreePages::class, function (Faker $faker) {
    return [
        'amount' => $faker->numberBetween(0, 100),
        'deadline' => $faker->dateTimeBetween($startDate = '-1 years', $endDate = '+1 years', $timezone=null, $format = 'Y-m-d'),
        'last_modified_by' => \App\User::first()->id,
        'comment' => $faker->text,
    ];
});
