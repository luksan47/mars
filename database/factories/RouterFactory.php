<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Router;
use Faker\Generator as Faker;

$factory->define(Router::class, function (Faker $faker) {
    $date_of_deployment = $faker->dateTime();
    return [
        'ip' => $faker->unique()->ipv4,
        'room' => $faker->unique()->numberBetween(200, 400),
        'failed_for' => $faker->numberBetween(0, 100),
        'port' => "2/2.0" . $faker->numberBetween(100, 200),
        'type' => $faker->company(),
        'serial_number' => $faker->ean13,
        'mac_5G' => $faker->macAddress,
        'mac_2G_LAN' => $faker->macAddress,
        'mac_WAN' => $faker->macAddress,
        'date_of_acquisition' => $faker->dateTime($max = $date_of_deployment),
        'date_of_deployment' => $date_of_deployment,
    ];
});
