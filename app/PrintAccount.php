<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PrintAccount extends Model
{
    protected $table = 'print_accounts';
    protected $primaryKey = 'user_id';
    public $incrementing = false;
    public $timestamps = false;

    const COST = [
        'twosided' => 12,
        'onesided' => 8,
    ];

    protected $fillable = [
        'user_id', 'balance', 'free_pages',
    ];

    /**
     * The model's default values for attributes.
     */
    protected $attributes = [
        'balance' => 0,
        'free_pages' => 0
    ];

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function hasEnoughMoney($balance) {
        return $this->balance >= abs($balance);
    }

    public static function getCost($pages, $twosided, $number_of_copies = 1) {
        if ($twosided) {
            $cost;
            if ($pages % 2 == 0) {
                $cost = $pages / 2 * PrintAccount::COST['twosided'];
            } else {
                $cost = ($pages  - 1) / 2 * PrintAccount::COST['twosided'] + $pages * PrintAccount::COST['onesided'];
            }
            return $cost * $number_of_copies;
        } else {
            return $pages * PrintAccount::COST['onesided'] * $number_of_copies;
        }
    }
}
