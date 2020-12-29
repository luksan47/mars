<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use SoftDeletes, HasFactory;

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
        return $this->belongsTo('App\Models\User');
    }

    public function payer()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function checkout()
    {
        return $this->belongsTo('App\Models\Checkout');
    }

    public function semester()
    {
        return $this->belongsTo('App\Models\Semester');
    }

    public function type()
    {
        return $this->belongsTo('App\Models\PaymentType', 'payment_type_id');
    }
}
