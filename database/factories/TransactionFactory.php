<?php

namespace Database\Factories;

use App\Models\Transaction;
use App\Models\Checkout;
use App\Models\PaymentType;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransactionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Transaction::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'checkout_id' => Checkout::all()->random()->id,
            'semester_id' => \App\Models\Semester::all()->random()->id,
            'payment_type_id' => function (array $attributes) {
                return PaymentType::forCheckout(Checkout::findOrFail($attributes['checkout_id']))
                    ->random();
            },
            'receiver_id' => function (array $attributes) {
                $payment_type = PaymentType::findOrFail($attributes['payment_type_id']);
                switch ($payment_type->name) {
                    case PaymentType::EXPENSE:
                        return null;
                    case PaymentType::INCOME:
                        return null;
                    case PaymentType::KKT:
                        return User::where('verified', true)->get()->random()->id;
                    case PaymentType::NETREG:
                        return User::where('verified', true)->get()->random()->id;
                    case PaymentType::PRINT:
                        return User::where('verified', true)->get()->random()->id;
                    default:
                        return null;
                }
            },
            'payer_id' => function (array $attributes) {
                $payment_type = PaymentType::findOrFail($attributes['payment_type_id']);
                switch ($payment_type->name) {
                    case PaymentType::EXPENSE:
                        return null;
                    case PaymentType::INCOME:
                        return null;
                    case PaymentType::KKT:
                        return User::where('verified', true)->get()->random()->id;
                    case PaymentType::NETREG:
                        return User::where('verified', true)->get()->random()->id;
                    case PaymentType::PRINT:
                        return User::where('verified', true)->get()->random()->id;
                    default:
                        return null;
                }
            },
            'amount' => function (array $attributes) {
                $payment_type = PaymentType::findOrFail($attributes['payment_type_id']);
                switch ($payment_type->name) {
                    case PaymentType::EXPENSE:
                        return round($this->faker->numberBetween(-100000, -1000), -3);
                    case PaymentType::INCOME:
                        return round($this->faker->numberBetween(1000, 100000), -3);
                    case PaymentType::KKT:
                        return config('custom.kkt');
                    case PaymentType::NETREG:
                        return config('custom.netreg');
                    case PaymentType::PRINT:
                        return round($this->faker->numberBetween(50, 1000), -1);
                    default:
                        return round($this->faker->numberBetween(1000, 100000), -3);
                }
            },
            'comment' => $this->faker->sentence,
            'moved_to_checkout' => ($this->faker->boolean
                &&  function (array $attributes) {
                    $payment_type_name = PaymentType::findOrFail($attributes['payment_type_id'])->name;
                    return in_array($payment_type_name, [PaymentType::KKT, PaymentType::NETREG, PaymentType::PRINT]);
                })
                ?   function (array $attributes) {
                    return \App\Models\Semester::findOrFail($attributes['semester_id'])
                        ->getStartDate()->addDays($this->faker->numberBetween(1, 100));
                }
                :   null, //not in checkout
            'created_at' => function (array $attributes) {
                return \App\Models\Semester::findOrFail($attributes['semester_id'])
                    ->getStartDate()->addDays($this->faker->numberBetween(1, 100));
            }
        ];
    }
}
