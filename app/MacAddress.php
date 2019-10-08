<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MacAddress extends Model
{
    const REQUESTED = "REQUESTED";
    const APPROVED = "APPROVED";
    const REJECTED = "REJECTED";

    protected $table = 'mac_addresses';

    protected $fillable = [
        'user_id', 'mac_address', 'comment', 'state',
    ];

    protected $attributes = [
        'comment' => "",
        'state' => "REQUESTED"
    ];

    function getState($value) {
        return strtoupper($value);
    }

    public function user() {
        return $this->belongsTo('App\User');
    }
}
