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
    const STAFF = 'staff';
    const LOCALE_ADMIN = 'locale-admin';
    const PERMISSION_HANDLER = 'permission-handler';
    const STUDENT_COUNCIL = 'student-council';

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
        self::STAFF,
        self::PRINTER,
        self::INTERNET_USER,
        self::LOCALE_ADMIN,
        self::PERMISSION_HANDLER,
        self::STUDENT_COUNCIL,
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

    public function object()
    {
        if (! $this->canHaveObject()) {
            return null;
        }

        return $this->possibleObjects()->where('id', $this->pivot->object_id)->first();
    }

    public static function getUsers(string $roleName)
    {
        return Role::firstWhere('name', $roleName)->users;
    }

    public static function getId(string $roleName)
    {
        return Role::where('name', $roleName)->first()->id;
    }

    public function canHaveObject()
    {
        // TODO: PERMISSION_HANDLER could also be there
        return in_array($this->name, [self::WORKSHOP_ADMINISTRATOR, self::WORKSHOP_LEADER, self::LOCALE_ADMIN, self::STUDENT_COUNCIL, self::COLLEGIST]);
    }

    public function possibleObjects()
    {
        if (in_array($this->name, [self::WORKSHOP_ADMINISTRATOR, self::WORKSHOP_LEADER])) {
            return \App\Workshop::all();
        }
        if ($this->name == self::LOCALE_ADMIN) {
            // Do we have this somewhere?
            $locales = collect([
                (object) ['id' => 0, 'name' => 'Magyar'],
                (object) ['id' => 1, 'name' => 'English'],
                (object) ['id' => 2, 'name' => 'Latina'],
                (object) ['id' => 3, 'name' => 'Français'],
                (object) ['id' => 4, 'name' => 'Italiano'],
                (object) ['id' => 5, 'name' => 'Deutsch'],
                (object) ['id' => 6, 'name' => 'Español'],
                (object) ['id' => 7, 'name' => 'Ελληνικά'],
            ]);

            return $locales;
        }
        if ($this->name == 'student-council') {
            $student_council_members = [
                'president',
                'vice_president',
                'economic-committee',
                'communication-committee',
                'community-committee',
                'cultural-committee',
                'sport-committee',
                'science-committee',
            ];
            $objects = [];
            $id = 1;
            foreach ($student_council_members as $name) {
                $objects[] = (object) ['id' => $id++, 'name' => __('role.'.$name)];
            }

            return collect($objects);
        }

        if ($this->name == 'collegist') {
            $collegists = [
                'resident',
                'extern',
            ];
            $objects = [];
            $id = 1;
            foreach ($collegists as $name) {
                $objects[] = (object) ['id' => $id++, 'name' => __('role.'.$name)];
            }

            return collect($objects);
        }

        return \App\Workshop::all();
    }

    public function color()
    {
        switch ($this->name) {
            case self::PRINT_ADMIN:
                return 'red';
            case self::INTERNET_ADMIN:
                return 'pink';
            case self::COLLEGIST:
                return 'coli';
            case self::TENANT:
                return 'coli blue';
            case self::WORKSHOP_ADMINISTRATOR:
                return 'purple';
            case self::WORKSHOP_LEADER:
                return 'deep-purple';
            case self::SECRETARY:
                return 'indigo';
            case self::DIRECTOR:
                return 'blue';
            case self::STAFF:
                return 'cyan';
            case self::PRINTER:
                return 'teal';
            case self::INTERNET_USER:
                return 'light-green';
            case self::LOCALE_ADMIN:
                return 'amber';
            case self::PERMISSION_HANDLER:
                return 'deep-orange';
            case self::STUDENT_COUNCIL:
                return 'green darken-4';
            default:
                return 'grey';
        }
    }

    public function hasElevatedPermissions()
    {
        return in_array($this->name, [self::PRINT_ADMIN, self::INTERNET_ADMIN, self::PERMISSION_HANDLER, self::SECRETARY]);
    }
}
