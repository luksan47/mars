<?php

namespace Database\Factories;

use App\Models\FreePages;
use Illuminate\Database\Eloquent\Factories\Factory;

class FreePagesFactory extends Factory
{
    protected $model = FreePages::class;

    public function definition()
    {
        return [
            'amount' => $this->faker->numberBetween(0, 100),
            'deadline' => $this->faker->dateTimeBetween($startDate = '-1 years', $endDate = '+1 years', $timezone = null, $format = 'Y-m-d'),
            'last_modified_by' => \App\Models\User::first()->id,
            'comment' => $this->faker->text,
        ];
    }
}
