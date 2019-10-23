<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    // General roles
    const PRINT_ADMIN = "print-admin";
    const INTERNET_ADMIN = "internet-admin";
    const COLLEGIST = "collegist";
    const TENANT = "tenant";
    const WORKSHOP_ADMINISTRATOR = "workshop-administrator";
    const WORKSHOP_LEADER = "workshop-leader";
    const SECRETARY = "secretary";
    const DIRECTOR = "director";
    const PRESIDENT = "president";
    const STAFF = "staff";
    
    // Module-related roles
    const PRINTER = "printer";
    const INTERNET_USER = "internet-user";

    // all roles
    const ALL = [
        self::PRINT_ADMIN,
        self::INTERNET_ADMIN,
        self::COLLEGIST,
        self::TENANT,
        self::WORKSHOP_ADMINISTRATOR,
        self::WORKSHOP_LEADER,
        self::SECRETARY,
        self::DIRECTOR,
        self::PRESIDENT,
        self::STAFF,
        self::PRINTER,
        self::INTERNET_USER,
    ];


    protected $fillable = [
        'name',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'role_users')->withPivot('object_id');
    }

    public function name() {
        return __('role.' . $name);
    }
}
