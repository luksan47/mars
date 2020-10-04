<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'checkout_id',
        'receiver_id',
        'payer_id',
        'semester_id',
        'amount',
        'payment_type_id',
        'comment',
        'moved_to_checkout',
    ];

    public function receiver()
    {
        return $this->belongsTo('App\User');
    }

    public function payer()
    {
        return $this->belongsTo('App\User');
    }

    public function checkout()
    {
        return $this->belongsTo('App\Checkout');
    }

    public function semester()
    {
        return $this->belongsTo('App\Semester');
    }

    public function type()
    {
        return $this->belongsTo('App\PaymentType', 'payment_type_id');
    }
}
