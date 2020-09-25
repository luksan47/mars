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
}
