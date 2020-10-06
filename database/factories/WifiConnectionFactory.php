<?php

namespace Database\Factories;

use App\Models\WifiConnection;
use Illuminate\Database\Eloquent\Factories\Factory;

class WifiConnectionFactory extends Factory {

    protected $model = WifiConnection::class;

    public function definition()
    {
        return [
            'ip' => $this->faker->unique()->ipv4,
            'mac_address' => $this->faker->macAddress,
            'wifi_username' => 'wifiuser' . $this->faker->numberBetween(1, 10),
            'created_at' => $this->faker->dateTimeBetween($startDate = '-15 days', $endDate = 'now', $timezone = null),
        ];
    }
}
