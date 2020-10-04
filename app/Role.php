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

    public static function getObjectIdByName($role, $objectName)
    {
        $objects = self::possibleObjectsFor($role);

        return $objects->where('name', $objectName)->first()->id;
    }

    public static function getUsers(string $roleName)
    {
        return self::firstWhere('name', $roleName)->users;
    }

    public static function getId(string $roleName)
    {
        return self::where('name', $roleName)->first()->id;
    }

    public function canHaveObject()
    {
        return self::canHaveObjectFor($this->name);
    }

    public static function canHaveObjectFor($name)
    {
        // TODO: PERMISSION_HANDLER could also be there
        return in_array($name, [self::WORKSHOP_ADMINISTRATOR, self::WORKSHOP_LEADER, self::LOCALE_ADMIN, self::STUDENT_COUNCIL, self::COLLEGIST]);
    }

    public function possibleObjects()
    {
        return self::possibleObjectsFor($this->name);
    }

    public static function possibleObjectsFor($name)
    {
        if (in_array($name, [self::WORKSHOP_ADMINISTRATOR, self::WORKSHOP_LEADER])) {
            return \App\Workshop::all();
        }
        if ($name == self::LOCALE_ADMIN) {
            // Do we have this somewhere?
            $locales = ['hu', 'en', 'la', 'fr', 'it', 'de', 'sp', 'gr'];

            return self::toSelectableCollection($locales);
        }

        if ($name == 'student-council') {
            $student_council_members = [
                'president',
                'vice_president',
                'economic-leader',
                'communication-leader',
                'community-leader',
                'cultural-leader',
                'sport-leader',
                'science-leader',
                'economic-member',
                'communication-member',
                'community-member',
                'cultural-member',
                'sport-member',
                'science-member',
            ];

            return self::toSelectableCollection($student_council_members);
        }

        if ($name == 'collegist') {
            $collegists = [
                'resident',
                'extern',
            ];

            return self::toSelectableCollection($collegists);
        }

        return [];
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
        return in_array($this->name, [self::PRINT_ADMIN, self::INTERNET_ADMIN, self::PERMISSION_HANDLER, self::SECRETARY, self::DIRECTOR]);
    }

    private static function toSelectableCollection(array $items)
    {
        $objects = [];
        $id = 1;
        foreach ($items as $name) {
            $objects[] = (object) ['id' => $id++, 'name' => $name];
        }

        return collect($objects);
    }
}
