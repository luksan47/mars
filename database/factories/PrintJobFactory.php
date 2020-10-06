<?php

namespace Database\Factories;

use App\Models\PrintJob;
use Illuminate\Database\Eloquent\Factories\Factory;

class PrintJobFactory extends Factory
{
    protected $model = PrintJob::class;

    public function definition()
    {
        return [
            'filename' => $this->faker->text,
            'filepath' => $this->faker->text,
            'state' => $this->faker->randomElement(PrintJob::STATES),
            'job_id' => $this->faker->randomNumber,
            'cost' => $this->faker->numberBetween(8, 1000),
        ];
    }
}
