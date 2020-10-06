<?php

namespace Database\Factories;

use App\Models\PersonalInformation;
use Illuminate\Database\Eloquent\Factories\Factory;

class PersonalInformationFactory extends Factory
{
    protected $model = PersonalInformation::class;

    public function definition()
    {
        return [
            'place_of_birth' => $this->faker->city,
            'date_of_birth' =>$this->faker->date($format = 'Y-m-d', $max = 'now'),
            'mothers_name' => $this->faker->name($gender = 'female'),
            'phone_number' => $this->faker->numerify('+36 (##) ###-####'),
            'country' => $this->faker->country,
            'county' => $this->faker->state,
            'zip_code' => $this->faker->postcode,
            'city' => $this->faker->city,
            'street_and_number' => $this->faker->streetAddress,
        ];
    }
}
