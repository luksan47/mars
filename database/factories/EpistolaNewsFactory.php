<?php

namespace Database\Factories;

use App\Models\EpistolaNews;
use Illuminate\Database\Eloquent\Factories\Factory;

class EpistolaNewsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = EpistolaNews::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->realText($maxNbChars = 50),
            'subtitle' => $this->faker->sentence(),
            'description' => $this->faker->text(500),
            'further_details' => $this->faker->url(),
            'website' => $this->faker->url(),
            'facebook_event' => $this->faker->url(),
            'registration' => $this->faker->url(),
            'registration_deadline' => now()->addDays($this->faker->numberBetween(0, 100)),
            'filling_deadline' => now()->addDays($this->faker->numberBetween(0, 100)),
            'date' => now()->addDays($this->faker->numberBetween(0, 200)),
            'end_date' => now()->addDays($this->faker->numberBetween(0, 200)),
            'picture' => $this->faker->imageUrl(640, 480, true),
            'valid_until' => now()->addDays($this->faker->numberBetween(0, 100)),
        ];
    }
}
