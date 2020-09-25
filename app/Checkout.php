<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Checkout extends Model
{
    protected $fillable = ['name', 'password'];
    protected $hidden = ['password'];

    public function transactions()
    {
        return $this->hasMany('App\Transaction');
    }

    public function kktSum(Semester $semester)
    {
        return $this->transactions
            ->where('payment_type_id', PaymentType::where('name', 'KKT')->firstOrFail()->id)
            ->where('semester_id', $semester->id)
            ->sum('amount');
    }
}
