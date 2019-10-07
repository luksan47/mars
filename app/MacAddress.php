<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MacAddress extends Model
{
    protected $table = 'mac_addresses';

    protected $fillable = [
        'user_id', 'mac_address', 'comment', 'state',
    ];

    protected $attributes = [
        'comment' => "",
        'state' => "REQUESTED"
    ];

    public function user() {
        return $this->belongsTo('App\User');
    }
}
