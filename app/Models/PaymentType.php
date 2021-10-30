<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class PaymentType extends Model
{
    protected $fillable = ['name'];

    const INCOME = 'INCOME';
    const EXPENSE = 'EXPENSE';
    const KKT = 'KKT';
    const NETREG = 'NETREG';
    const PRINT = 'PRINT';
    const TYPES = [
        self::INCOME,
        self::EXPENSE,
        self::KKT,
        self::NETREG,
        self::PRINT,
    ];

    /**
     * Get the payment types (collection) belonging to a checkout.
     * INCOME and EXPENSE belong to all checkout.
     *
     * Other, special types:
     * ADMIN: NETREG, PRINT;
     * STUDENTS_COUNCIL: KKT
     *
     * Uses cache.
     * @param Checkout
     * @return collection of the payment types.
     */
    public static function forCheckout(Checkout $checkout)
    {
        return Cache::remember('paymentTypesFor.'.$checkout, 86400, function () use ($checkout) {
            $payment_types = [self::INCOME, self::EXPENSE];
            if ($checkout->name == Checkout::ADMIN) {
                $payment_types[] = self::NETREG;
                $payment_types[] = self::PRINT;
            } elseif ($checkout->name == Checkout::STUDENTS_COUNCIL) {
                $payment_types[] = self::KKT;
            }

            return self::whereIn('name', $payment_types)->get();
        });
    }

    public static function income(): PaymentType
    {
        return self::getFromCache(self::INCOME);
    }

    public static function expense(): PaymentType
    {
        return self::getFromCache(self::EXPENSE);
    }

    public static function kkt(): PaymentType
    {
        return self::getFromCache(self::KKT);
    }

    public static function netreg(): PaymentType
    {
        return self::getFromCache(self::NETREG);
    }

    public static function print(): PaymentType
    {
        return self::getFromCache(self::PRINT);
    }

    /**
     * Get the paymentType by name. Uses cache.
     * @param string payment type name
     * @return PaymentType
     */
    public static function getFromCache(string $type): PaymentType
    {
        return Cache::remember('paymentType.'.$type, 86400, function () use ($type) {
            return self::where('name', $type)->firstOrFail();
        });
    }

    /**
     * Get the paymentType by name. Uses cache.
     * @param string payment type name
     * @return PaymentType
     */
    public static function getByName(string $name): PaymentType
    {
        return self::getFromCache($name);
    }
}
