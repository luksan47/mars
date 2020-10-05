<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MacAddress extends Model
{
    use HasFactory;

    const REQUESTED = 'REQUESTED';
    const APPROVED = 'APPROVED';
    const REJECTED = 'REJECTED';
    const STATES = [self::APPROVED, self::REJECTED, self::REQUESTED];

    protected $table = 'mac_addresses';

    protected $fillable = [
        'user_id', 'mac_address', 'comment', 'state',
    ];

    protected $attributes = [
        'comment' => '',
        'state' => self::REQUESTED,
    ];

    public function getState($value)
    {
        return strtoupper($value);
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
