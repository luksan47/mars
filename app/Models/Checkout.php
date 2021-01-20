<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Checkout extends Model
{
    protected $fillable = ['name', 'password'];
    protected $hidden = ['password'];

    const STUDENTS_COUNCIL = 'VALASZTMANY';
    const ADMIN = 'ADMIN';
    const TYPES = [
        self::STUDENTS_COUNCIL,
        self::ADMIN,
    ];

    public function transactions()
    {
        return $this->hasMany('App\Models\Transaction');
    }

    /**
     * @return int the sum of the transactions
     */
    public function balance(): int
    {
        return $this->transactions->sum('amount');
    }

    /**
     * @return int the sum of the transactions which are not moved to the checkout
     */
    public function balanceInCheckout(): int
    {
        return $this->transactions
            ->where('moved_to_checkout', '<>', null)
            ->sum('amount');
    }

    /**
     * @return Checkout the admin checkout from cache
     */
    public static function admin(): Checkout
    {
        return Cache::remember('checkout.'.self::ADMIN, 86400, function () {
            return self::where('name', self::ADMIN)->firstOrFail();
        });
    }

    /**
     * @return Checkout the student council's checkout from cache
     */
    public static function studentsCouncil(): Checkout
    {
        return Cache::remember('checkout.'.self::STUDENTS_COUNCIL, 86400, function () {
            return self::where('name', self::STUDENTS_COUNCIL)->firstOrFail();
        });
    }

    public function kktSum(Semester $semester): int
    {
        return $this->transactionSum($semester, PaymentType::kkt()->id);
    }

    public function netregSum(Semester $semester): int
    {
        return $this->transactionSum($semester, PaymentType::netreg()->id);
    }

    public function printSum(Semester $semester): int
    {
        return $this->transactionSum($semester, PaymentType::print()->id);
    }

    public function transactionSum(Semester $semester, $typeId): int
    {
        return $this->transactions
            ->where('payment_type_id', $typeId)
            ->where('semester_id', $semester->id)
            ->sum('amount');
    }
}
