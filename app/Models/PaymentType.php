<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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

    public static function print()
    {
        return self::where('name', self::PRINT)->firstOrFail();
    }

    public static function getByName(string $name)
    {
        return self::where('name', $name)->firstOrFail();
    }
}
