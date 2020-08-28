<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    // General roles
    const PRINT_ADMIN = 'print-admin';
    const INTERNET_ADMIN = 'internet-admin';
    const COLLEGIST = 'collegist';
    const TENANT = 'tenant';
    const WORKSHOP_ADMINISTRATOR = 'workshop-administrator';
    const WORKSHOP_LEADER = 'workshop-leader';
    const SECRETARY = 'secretary';
    const DIRECTOR = 'director';
    const PRESIDENT = 'president';
    const STAFF = 'staff';
    const LOCALE_ADMIN = 'locale-admin';
    const PERMISSION_HANDLER = 'permission-handler';

    // Module-related roles
    const PRINTER = 'printer';
    const INTERNET_USER = 'internet-user';

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
        self::LOCALE_ADMIN,
        self::PERMISSION_HANDLER,
    ];

    protected $fillable = [
        'name',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'role_users')->withPivot('object_id');
    }

    public function name()
    {
        return __('role.'.$this->name);
    }

    public static function getId(string $roleName)
    {
        return Role::where('name', $roleName)->first()->id;
    }

    public function canHaveObject()
    {
        // TODO: PERMISSION_HANDLER could also be there
        return in_array($this->name, [self::WORKSHOP_ADMINISTRATOR, self::WORKSHOP_LEADER, self::LOCALE_ADMIN]);
    }

    public function possibleObjects()
    {
        // TODO
        return \App\Workshop::all();
    }

    public function color()
    {
        switch ($this->name) {
            case self::PRINT_ADMIN:
                return 'red';
                break;
            case self::INTERNET_ADMIN:
                return 'pink';
                break;
            case self::COLLEGIST:
                return 'coli';
                break;
            case self::TENANT:
                return 'coli blue';
                break;
            case self::WORKSHOP_ADMINISTRATOR:
                return 'purple';
                break;
            case self::WORKSHOP_LEADER:
                return 'deep-purple';
                break;
            case self::SECRETARY:
                return 'indigo';
                break;
            case self::DIRECTOR:
                return 'blue';
                break;
            case self::PRESIDENT:
                return 'light-blue';
                break;
            case self::STAFF:
                return 'cyan';
                break;
            case self::PRINTER:
                return 'teal';
                break;
            case self::INTERNET_USER:
                return 'light-green';
                break;
            case self::LOCALE_ADMIN:
                return 'amber';
                break;
            case self::PERMISSION_HANDLER:
                return 'deep-orange';
                break;
            default:
                return 'grey';
                break;
        }
    }
}
