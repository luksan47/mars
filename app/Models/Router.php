<?php

namespace App\Models;

use App\Utils\NotificationCounter;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;

class Router extends Model
{
    use NotificationCounter, HasFactory;

    protected $table = 'routers';
    protected $primaryKey = 'ip';
    public $incrementing = false;
    public $timestamps = false;

    // We send a warning to the network admins on the second error.
    const WARNING_THRESHOLD = 2;

    protected $fillable = [
        'ip', 'room', 'failed_for', 'port', 'type', 'serial_number',
        'mac_WAN', 'mac_2G_LAN', 'mac_5G', 'comment',
        'date_of_acquisiton', 'date_of_deployment'
    ];

    public function isDown()
    {
        return $this->failed_for > 0;
    }

    public function isUp()
    {
        return $this->failed_for == 0;
    }

    public function getFailStartDate()
    {
        return Carbon::now()->subMinutes($this->failed_for * 5)->roundMinute(5)->format('Y-m-d H:i');
    }

    public function sendWarning()
    {
        if ($this->failed_for == self::WARNING_THRESHOLD) {
            $internet_admins = Role::getUsers(Role::NETWORK_ADMIN);
            foreach ($internet_admins as $admin) {
                Mail::to($admin)->queue(new \App\Mail\RouterWarning($admin, $this));
            }
        }
    }

    public static function notifications()
    {
        return self::where('failed_for', '>', 0)->count();
    }
}
