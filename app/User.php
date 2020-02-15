<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

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

    public function printAccount()
    {
        return $this->hasOne('App\PrintAccount');
    }

    public function internetAccess()
    {
        return $this->hasOne('App\InternetAccess');
    }

    public function macAddresses()
    {
        return $this->hasMany('App\MacAddress');
    }

    public function personalInformation()
    {
        return $this->hasOne('App\PersonalInformation');
    }

    public function workshops()
    {
        return $this->belongsToMany(Workshop::class, 'workshop_users');
    }

    public function faculties()
    {
        return $this->belongsToMany(Faculty::class, 'faculty_users');
    }

    public function printJobs()
    {
        return $this->hasMany('App\PrintJob');
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_users')->withPivot('object_id');
    }

    public function hasAnyRole(array $roleNames, $objectId = null)
    {
        return $this->roles->contains(function ($value, $key) use ($roleNames, $objectId) {
            return in_array($value->name, $roleNames) && $value->pivot->object_id === $objectId;
        });
    }

    public function hasRole(string $roleName, $objectId = null)
    {
        return $this->hasAnyRole([$roleName], $objectId);
    }

    /**
     * @deprecated use hasRole instead
     */
    public function isAdmin()
    {
        trigger_error('Method '.__METHOD__.' is deprecated', E_USER_DEPRECATED);

        return $this->hasRole(['admin']);
    }
}
