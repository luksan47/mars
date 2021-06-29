<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class Role extends Model
{
    // General roles
    const PRINT_ADMIN = 'print-admin';
    const NETWORK_ADMIN = 'internet-admin';
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

    //Student committe role's objects
    const PRESIDENT = 'president';
    const VICE_PRESIDENT = 'vice_president';
    const ECONOMIC_LEADER = 'economic-leader';
    const ECONOMIC_MEMBER = 'economic-member';
    const CULTURAL_LEADER = 'cultural-leader';
    const CULTURAL_MEMBER = 'cultural-member';
    const COMMUNITY_LEADER = 'community-leader';
    const COMMUNITY_MEMBER = 'community-member';
    const COMMUNICATION_LEADER = 'communication-leader';
    const COMMUNICATION_MEMBER = 'communication-member';
    const SPORT_LEADER = 'sport-leader';
    const SPORT_MEMBER = 'sport-member';
    const SCIENCE_LEADER = 'science-leader';
    const SCIENCE_MEMBER = 'science-member';
    const COMMITTEE_LEADERS = [
        self::ECONOMIC_LEADER,
        self::CULTURAL_LEADER,
        self::COMMUNITY_LEADER,
        self::COMMUNICATION_LEADER,
        self::SPORT_LEADER,
        self::SCIENCE_LEADER
    ];
    const STUDENT_COUNCIL_LEADERS = [
        self::PRESIDENT,
        self::VICE_PRESIDENT
    ];

    const STUDENT_COUNCIL_MEMBERS = [
        self::ECONOMIC_LEADER,
        self::CULTURAL_LEADER,
        self::COMMUNITY_LEADER,
        self::COMMUNICATION_LEADER,
        self::SPORT_LEADER,
        self::SCIENCE_LEADER
    ];

    // Module-related roles
    const PRINTER = 'printer';
    const INTERNET_USER = 'internet-user';

    // all roles
    const ALL = [
        self::PRINT_ADMIN,
        self::NETWORK_ADMIN,
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

    /**
     * @return string the translated role
     */
    public function name(): string
    {
        //TODO: workshop leader / administrator roles are translated elsewhere
        return __('role.' . $this->name);
    }

    /**
     * Returns true if the role can be attached to only one user at a time.
     * @param int $roleId
     * @param string $objectName optional. Returns false if the object is null for a role which can have objects.
     * @return bool
     */
    public static function isUnique($roleName, $objectName = null): bool
    {
        if (!self::canHaveObjectFor($roleName)) {
            return in_array($roleName, [
                self::DIRECTOR
            ]);
        } else {
            if ($objectName == null) return false;
            if ($roleName == self::STUDENT_COUNCIL) {
                return in_array($objectName, array_merge(self::COMMITTEE_LEADERS, [self::PRESIDENT]));
            }
            return in_array($roleName, [
                self::WORKSHOP_ADMINISTRATOR,
                self::WORKSHOP_LEADER
            ]);
        }
    }


    /**
     * Checks if the specified role can be attached to someone.
     * Object id is required if the role can have objects. (returns -1)
     * If a role is unique and taken, returns the user's id who is attached to that role.
     * Returns 0 if the role can be attached.
     * @param int $roleId
     * @param int $objectId optional
     * @return int 0, -1, or a user id.
     */
    public static function canBeAttached($roleId, $objectId = null): int
    {
        $roleName = self::findOrFail($roleId)->name;
        $object = self::possibleObjectsFor($roleName)->firstWhere('id', $objectId);
        if (self::isUnique($roleName, ($object ? $object->name : null))) {
            if (self::canHaveObjectFor($roleName)) {
                if ($object == null) return -1;
                $row = DB::table('role_users')
                    ->where('role_id', $roleId)
                    ->where('object_id', $objectId)
                    ->first();
                return ($row ? $row->user_id : 0);
            }
            if ($objectId != null) return -1;

            $row = DB::table('role_users')->where('role_id', $roleId)->first();
            return ($row ? $row->user_id : 0);
        }
        return 0;
    }

    /**
     * Returns the object (with id and name) of the role or null if the role does not have.
     */
    public function object()
    {
        if (!$this->canHaveObject()) {
            return null;
        }

        return $this->possibleObjects()->where('id', $this->pivot->object_id)->first();
    }

    public static function getObjectIdByName($roleName, $objectName)
    {
        $objects = self::possibleObjectsFor($roleName);
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

    /**
     * Returns if the role can have objects
     */
    public function canHaveObject(): bool
    {
        return self::canHaveObjectFor($this->name);
    }

    /**
     * Returns if the role can have objects.
     * @return string object name
     */
    public static function canHaveObjectFor($name): bool
    {
        // TODO: PERMISSION_HANDLER could also be there
        return in_array($name, [
            self::WORKSHOP_ADMINISTRATOR,
            self::WORKSHOP_LEADER,
            self::LOCALE_ADMIN,
            self::STUDENT_COUNCIL,
            self::COLLEGIST
        ]);
    }

    /**
     * Returns the collection of the possible object for the role.
     * @return collection of the objects with id (starting from 1, except workshops?) and name.
     */
    public function possibleObjects()
    {
        return self::possibleObjectsFor($this->name);
    }

    /**
     * Returns the collection of the possible object for a role.
     * @param string $name the role's name
     * @return collection of the objects with id (starting from 1, except workshops?) and name.
     */
    public static function possibleObjectsFor($name)
    {
        if (in_array($name, [self::WORKSHOP_ADMINISTRATOR, self::WORKSHOP_LEADER])) {
            return Cache::remember('workshop.all', 60 * 60 * 24, function () {
                return Workshop::all();
            });
        }
        if ($name == self::LOCALE_ADMIN) {
            $locales = array_keys(config('app.locales'));

            return self::toSelectableCollection($locales);
        }

        if ($name == self::STUDENT_COUNCIL) {
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

        if ($name == self::COLLEGIST) {
            $collegists = [
                'resident',
                'extern',
            ];

            return self::toSelectableCollection($collegists);
        }

        return collect([]);
    }

    public function color()
    {
        switch ($this->name) {
            case self::PRINT_ADMIN:
                return 'red';
            case self::NETWORK_ADMIN:
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

    public function hasElevatedPermissions(): bool
    {
        return in_array($this->name, [self::PRINT_ADMIN, self::NETWORK_ADMIN, self::PERMISSION_HANDLER, self::SECRETARY, self::DIRECTOR]);
    }

    public function hasTranslatedName(): bool
    {
        return in_array($this->name, [self::WORKSHOP_ADMINISTRATOR, self::WORKSHOP_LEADER]);
    }

    /**
     * Create a collection with id and name of the items in an array.
     * The ids starts at 1.
     * @param array $items the items in the array will be the name attributes
     * @return collection
     */
    private static function toSelectableCollection(array $items)
    {
        $objects = [];
        $id = 1;
        foreach ($items as $name) {
            $objects[] = (object) ['id' => $id++, 'name' => $name];
        }

        return collect($objects);
    }

    public function isSysAdmin()
    {
        return in_array($this->name, [self::NETWORK_ADMIN]);
    }
}
