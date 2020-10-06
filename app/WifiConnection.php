<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class WifiConnection extends Model
{
    protected $table = 'wifi_connections';
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = true;
    protected $fillable = [
        'ip',
        'mac_address',
        'wifi_username',
    ];

    const WARNING_THRESHOLD = 3;

    public function internetAccess()
    {
        return $this->belongsTo('App\InernetAccess', 'wifi_username', 'wifi_username');
    }

    public function user()
    {
        return $this->hasOneThrough(
            'App\User',
            'App\InternetAccess',
            'wifi_username', // Foreign key on cars table...
            'id', // Foreign key on owners table...
            'wifi_username', // Local key on mechanics table...
            'user_id' // Local key on cars table...
        );
    }

    public function getColor()
    {
        if ($this->created_at > Carbon::now()->subDays(5)) {
            return 'red';
        }
        if ($this->created_at > Carbon::now()->subDays(10)) {
            return 'orange';
        }
        return 'green';
    }
}
