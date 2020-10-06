<?php

namespace Database\Factories;

use App\Models\Course;
use App\Models\Semester;
use Illuminate\Database\Eloquent\Factories\Factory;

class CourseFactory extends Factory
{
    protected $model = Course::class;

    public function definition()
    {
        return [
            'code' => $this->faker->slug,
            'workshop_id' => \App\Models\Workshop::find(1)->id, //TODO: $faker->
            'name' => $this->faker->catchPhrase,
            'name_english' => $this->faker->bs,
            'type' => $this->faker->randomElement(Course::TYPES),
            'credits' => $this->faker->randomDigit,
            'hours' => $this->faker->numberBetween(1, 3),
            'semester_id' => Semester::find(1)->id, //TODO: $faker->
            'teacher_id' => Semester::find(1)->id, //TODO: $faker->
            'updated_at' => now(),
            'created_at' => now(),
        ];
    }
}
