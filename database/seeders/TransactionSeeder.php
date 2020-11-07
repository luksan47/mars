<?php

namespace Database\Seeders;

use App\Models\PaymentType;
use App\Models\Transaction;
use Illuminate\Database\Seeder;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Transaction::factory()->count(300)->create();
        Transaction::factory()->count(10)->create([
            'payment_type_id' => array_rand([
                PaymentType::kkt()->id,
                PaymentType::netreg()->id,
                PaymentType::print()->id,
            ]),
            'receiver_id' => 1,
        ]);
    }
}
