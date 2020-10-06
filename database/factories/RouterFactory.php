<?php

namespace Database\Factories;

use App\Models\Router;
use Illuminate\Database\Eloquent\Factories\Factory;

class RouterFactory extends Factory
{
    protected $model = Router::class;

    public function definition()
    {
        $date_of_deployment = $this->faker->dateTime();

        return [
            'ip' => $this->faker->unique()->ipv4,
            'room' => $this->faker->unique()->numberBetween(200, 400),
            'failed_for' => $this->faker->numberBetween(0, 100),
            'port' => '2/2.0'.$this->faker->numberBetween(100, 200),
            'type' => $this->faker->company(),
            'serial_number' => $this->faker->ean13,
            'mac_5G' => $this->faker->macAddress,
            'mac_2G_LAN' => $this->faker->macAddress,
            'mac_WAN' => $this->faker->macAddress,
            'date_of_acquisition' => $this->faker->dateTime($max = $date_of_deployment),
            'date_of_deployment' => $date_of_deployment,
        ];
    }
}
