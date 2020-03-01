<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\PrintAccount;
use Faker\Generator as Faker;

$factory->define(PrintAccount::class, function (Faker $faker) {
    return [
        'balance' => 0,
        'free_pages' => 0,
        'free_page_deadline' => null,
    ];
});
