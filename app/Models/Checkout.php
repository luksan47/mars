<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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

    public function balance()
    {
        return $this->transactions->sum('amount');
    }

    public function balanceInCheckout()
    {
        return $this->transactions
            ->where('moved_to_checkout', '<>', null)
            ->sum('amount');
    }

    public static function admin()
    {
        return self::where('name', self::ADMIN)->firstOrFail();
    }

    public static function studentsCouncil()
    {
        return self::where('name', self::STUDENTS_COUNCIL)->firstOrFail();
    }

    public function kktSum(Semester $semester)
    {
        return $this->transactionSum($semester, PaymentType::kkt()->id);
    }

    public function netregSum(Semester $semester)
    {
        return $this->transactionSum($semester, PaymentType::netreg()->id);
    }

    public function printSum(Semester $semester)
    {
        return $this->transactionSum($semester, PaymentType::print()->id);
    }
    public function transactionSum(Semester $semester, $typeId){
        return $this->transactions
            ->where('payment_type_id', $typeId)
            ->where('semester_id', $semester->id)
            ->sum('amount');
    }
}
