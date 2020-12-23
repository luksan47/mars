<?php

namespace Database\Seeders;

use App\Models\Checkout;
use App\Models\PaymentType;
use App\Models\Transaction;
use App\Models\Semester;
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
    }
}
