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

    public static function income()
    {
        return self::getFromCache(self::INCOME);
    }

    public static function expense()
    {
        return self::getFromCache(self::EXPENSE);
    }

    public static function kkt()
    {
        return self::getFromCache(self::KKT);
    }

    public static function netreg()
    {
        return self::getFromCache(self::NETREG);
    }

    public static function print()
    {
        return self::getFromCache(self::PRINT);
    }

    public static function getFromCache($type) {
        return Cache::remember('paymentType.'.$type, 86400, function () use ($type) {
            return self::where('name', $type)->firstOrFail();
        });
    }
}
