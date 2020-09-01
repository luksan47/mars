<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PrintAccount extends Model
{
    protected $table = 'print_accounts';
    protected $primaryKey = 'user_id';
    public $incrementing = false;
    public $timestamps = false;

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
}
