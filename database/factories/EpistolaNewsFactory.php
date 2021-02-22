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
            'uploader_id' => \App\Models\User::where('verified', true)->get()->random()->id,
            'title' => $this->faker->realText($maxNbChars = 50),
            'subtitle' => $this->faker->sentence(),
            'description' => $this->faker->paragraphs($this->faker->numberBetween(1, 3), true),
            'details_name_1' => $this->faker->boolean(50) ? $this->faker->realText(20) : null,
            'details_name_2' => $this->faker->boolean(50) ? $this->faker->realText(20) : null,
            'details_url_1' => function (array $attributes) {
                if ($attributes['details_name_1'] != null) {
                    return $this->faker->url();
                }

                return null;
            },
            'details_url_2' => function (array $attributes) {
                if ($attributes['details_name_2'] != null) {
                    return $this->faker->url();
                }

                return null;
            },
            'deadline_name' => $this->faker->boolean(50) ? $this->faker->realText(20) : null,
            'deadline_date' => function (array $attributes) {
                if ($attributes['deadline_date'] != null) {
                    return now()->addDays($this->faker->numberBetween(0, 100));
                }

                return null;
            },
            'date' => $this->faker->boolean(50) ? now()->addDays($this->faker->numberBetween(0, 200)) : null,
            'time' => function (array $attributes) {
                if ($attributes['date'] != null && $this->faker->boolean(50)) {
                    return now()->addMinutes($this->faker->numberBetween(0, 3600));
                }

                return null;
            },
            'end_date' => function (array $attributes) {
                if ($attributes['date'] != null && $attributes['time'] == null && $this->faker->boolean(50)) {
                    return now()->addDays($this->faker->numberBetween(0, 200));
                }

                return null;
            },
            'picture_path' => $this->faker->boolean(50) ? $this->faker->imageUrl(640, 480, 'animals', true) : null,
            'sent' => $this->faker->boolean(20),
        ];
    }
}
