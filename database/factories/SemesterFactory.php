<?php

namespace Database\Factories;

use App\Semester;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factories\Factory;

class SemesterFactory extends Factory {

    protected $model = Semester::class;

    public function definition() {
        return [
            'year' => $this->faker->numberBetween(2020, 2030),
            'part' => $this->faker->randomElements(Semester::PARTS),
        ];
    }
}
