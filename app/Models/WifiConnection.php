<?php

namespace App\Models;

use App\Utils\NotificationCounter;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WifiConnection extends Model
{
    use HasFactory, NotificationCounter;

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
        return $this->belongsTo('App\Models\InernetAccess', 'wifi_username', 'wifi_username');
    }

    public function user()
    {
        return $this->hasOneThrough(
            'App\Models\User',
            'App\Models\InternetAccess',
            'wifi_username', // Foreign key on InternetAccess table...
            'id', // Foreign key on Users table...
            'wifi_username', // Local key on WifiConnection table...
            'user_id' // Local key on InternetAccess table...
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

    public static function notifications()
    {
        return User::role(Role::INTERNET_USER)->select('id')->get()->where('reachedWifiConnectionLimit', true)->count();
    }
}
