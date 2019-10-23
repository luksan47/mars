<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InternetAccess extends Model
{
    protected $primaryKey = 'user_id';

    protected $fillable = ['user_id'];
    protected $hidden = ['wifi_password'];

    protected $dates = [
        'has_internet_until',
    ];

    public function user() {
        return $this->belongsTo('App\User');
    }
}
