<?php

namespace Database\Factories;

use App\PrintAccount;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factories\Factory;

class PrintAccountFactory extends Factory {

    protected $model = PrintAccount::class;

    public function definition() {
        return [
            'balance' => 0,
        ];
    }
}
