<?php

namespace App;

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

    public function internetAccess()
    {
        return $this->belongsTo('App\InernetAccess', 'wifi_username', 'wifi_username');
    }
}
