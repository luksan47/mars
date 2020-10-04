<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentType extends Model
{
    protected $fillable = ['name'];

    const INCOME = 'INCOME';
    const EXPENSE = 'EXPENSE';
    const KKT = 'KKT';
    const NETREG = 'NETREG';
    const TYPES = [
        self::INCOME,
        self::EXPENSE,
        self::KKT,
        self::NETREG,
    ];

    public static function income()
    {
        return self::where('name', self::INCOME)->firstOrFail();
    }

    public static function expense()
    {
        return self::where('name', self::EXPENSE)->firstOrFail();
    }

    public static function kkt()
    {
        return self::where('name', self::KKT)->firstOrFail();
    }

    public static function netreg()
    {
        return self::where('name', self::NETREG)->firstOrFail();
    }
}
