<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\PrintAccount;
use App\Models\PersonalInformation;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory {

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'email_verified_at' => now(),
            'password' => bcrypt('asdasdasd'), // password
            'remember_token' => Str::random(10),
            'verified' => $this->faker->boolean($chanceOfGettingTrue = 75),
        ];
    }

    /**
     * Configure the model factory.
     *
     * @return $this
     */
    public function configure()
    {
        return $this->afterMaking(function (User $user) {
            //
        })->afterCreating(function (User $user) {
            $user->printAccount()->save(PrintAccount::factory()->make(['user_id' => $user->id]));
            $user->personalInformation()->save(PersonalInformation::factory()->make(['user_id' => $user->id]));
        });
    }

}
