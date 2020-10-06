<?php

namespace Database\Factories;

use App\Models\PrintAccount;
use Illuminate\Database\Eloquent\Factories\Factory;

class PrintAccountFactory extends Factory
{
    protected $model = PrintAccount::class;

    public function definition()
    {
        return [
            'balance' => 0,
        ];
    }
}
