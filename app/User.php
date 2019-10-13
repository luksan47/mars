<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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
  
    public function printJobs()
    {
        return $this->hasMany('App\PrintJob');
    }

    public function roles() {
        return $this->belongsToMany(Role::class, 'role_users');
    }

    public function inRole(array $roleNames, $objectId = null)
    {
        return DB::table('role_users')
                ->join('roles', 'roles.id', '=', 'role_users.role_id')
                ->where('role_users.user_id', '=', $this->id)
                ->whereIn('roles.name', $roleNames)
                ->where('role_users.object_id', '=', $objectId)
                ->count() > 0;
    }

    public function isAdmin() {
        return $this->inRole(['admin']);
    }
}
