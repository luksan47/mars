<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\WifiConnection;
use Faker\Generator as Faker;

$factory->define(WifiConnection::class, function (Faker $faker) {
    return [
        'ip' => $faker->unique()->ipv4,
        'mac_address' => $faker->macAddress,
        'wifi_username' => 'wifiuser' . $faker->numberBetween(1, 10),
        'created_at' => $faker->dateTimeBetween($startDate = '-15 days', $endDate = 'now', $timezone = null),
    ];
});
