<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'verified',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function printAccount() {
        return $this->hasOne('App\PrintAccount');
    }

    public function internetAccess() {
        $relation = $this->hasOne('App\InternetAccess');
        if($relation->count() < 1) {
            InternetAccess::create([ 'user_id' => $this->id ]);
        }
        return $relation;
    }

    public function macAddresses() {
        return $this->hasMany('App\MacAddress');
    }

    public function isAdmin() {
        return $this->permission == 1;
    }
}
