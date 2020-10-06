<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InternetAccess extends Model
{
    protected $primaryKey = 'user_id';

    protected $fillable = ['user_id', 'wifi_username'];
    protected $hidden = ['wifi_password'];

    protected $dates = [
        'has_internet_until',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function isActive()
    {
        return $this->has_internet_until != null && $this->has_internet_until > date('Y-m-d');
    }

    public function setWifiUsername($username = null)
    {
        if ($username === null) {
            if ($this->user->hasRoleBase(Role::COLLEGIST) && isset($this->personalInformation)) {
                $username = $this->personalInformation->neptun;
            } else {
                $username = 'wifiuser'.$this->user->id;
            }
        }
        $this->update(['wifi_username' => $username]);
    }
}
