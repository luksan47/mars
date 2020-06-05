<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PrintAccount extends Model
{
    protected $table = 'print_accounts';
    protected $primaryKey = 'user_id';
    public $incrementing = false;
    public $timestamps = false;

    public static $COST;

    protected $fillable = [
        'user_id', 'balance', 'free_pages',
    ];

    /**
     * The model's default values for attributes.
     */
    protected $attributes = [
        'balance' => 0,
        'free_pages' => 0,
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function hasEnoughMoney($balance)
    {
        return $this->balance >= abs($balance);
    }

    public static function getCost($pages, $is_two_sided, $number_of_copies = 1)
    {
        if (! $is_two_sided) {
            return $pages * self::$COST['one_sided'] * $number_of_copies;
        }

        $orphan_ending = $pages % 2;
        $one_copy_cost = floor($pages / 2) * self::$COST['two_sided']
            + $orphan_ending * self::$COST['one_sided'];

        return $one_copy_cost * $number_of_copies;
    }
}

PrintAccount::$COST = [
    'one_sided' => env('PRINT_COST_ONESIDED'),
    'two_sided' => env('PRINT_COST_TWOSIDED'),
];
