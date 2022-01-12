<?php

namespace App\Models;

use App\Utils\NotificationCounter;
use Illuminate\Contracts\Translation\HasLocalePreference;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use InvalidArgumentException;

class User extends Authenticatable implements HasLocalePreference
{
    use NotificationCounter, Notifiable, HasFactory;

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

    protected static function booted()
    {
        // By default, unverified users will be excluded.
        // You can use `withoutGlobalScope('verified')` to include them.
        static::addGlobalScope('verified', function (Builder $builder) {
            // This condition prevents side-effects for unverified users.
            if (Auth::hasUser() && Auth::user()->verified) {
                $builder->where('verified', true);
            }
        });
    }

    /**
     * Get the user's preferred locale.
     *
     * @return string
     */
    public function preferredLocale(): string
    {
        //TODO store preferred locale for each user
        return 'hu';
    }

    /* Printing related getters */

    public function printAccount()
    {
        return $this->hasOne('App\Models\PrintAccount');
    }

    public function freePages()
    {
        return $this->hasMany('App\Models\FreePages');
    }

    public function sumOfActiveFreePages(): int
    {
        return $this->freePages
            ->where('deadline', '>', \Carbon\Carbon::now())
            ->sum('amount');
    }

    public function printHistory()
    {
        return $this->hasMany('App\Models\PrintAccountHistory');
    }

    public function printJobs()
    {
        return $this->hasMany('App\Models\PrintJob');
    }

    public function numberOfPrintedDocuments(): int
    {
        return $this->hasMany('App\Models\PrintAccountHistory')
            ->where('balance_change', '<', 0)
            ->orWhere('free_page_change', '<', 0)
            ->count();
    }

    public function spentBalance(): int
    {
        return abs($this->hasMany('App\Models\PrintAccountHistory')
            ->where('balance_change', '<', 0)
            ->sum('balance_change'));
    }

    public function spentFreePages(): int
    {
        return abs($this->hasMany('App\Models\PrintAccountHistory')
            ->where('free_page_change', '<', 0)
            ->sum('free_page_change'));
    }

    /* Internet module related getters */

    public function internetAccess()
    {
        return $this->hasOne('App\Models\InternetAccess');
    }

    public function macAddresses()
    {
        return $this->hasMany('App\Models\MacAddress');
    }

    public function wifiConnections()
    {
        return $this->hasManyThrough(
            'App\Models\WifiConnection',
            'App\Models\InternetAccess',
            'user_id', // Foreign key on InternetAccess table...
            'wifi_username', // Foreign key on WifiConnection table...
            'id', // Local key on Users table...
            'wifi_username' // Local key on InternetAccess table...
        );
    }

    public function getReachedWifiConnectionLimitAttribute(): bool
    {
        return $this->internetAccess->reachedWifiConnectionLimit();
    }

    /* Basic information of the user */

    public function setVerified(): void
    {
        $this->update([
            'verified' => true,
        ]);
    }

    public function personalInformation()
    {
        return $this->hasOne('App\Models\PersonalInformation');
    }

    public function hasPersonalInformation()
    {
        return isset($this->personalInformation);
    }

    public function educationalInformation()
    {
        return $this->hasOne('App\Models\EducationalInformation');
    }

    public function hasEducationalInformation()
    {
        return isset($this->educationalInformation);
    }

    public function application()
    {
        return $this->hasOne('App\Models\ApplicationForm');
    }

    public function workshops()
    {
        return $this->belongsToMany(Workshop::class, 'workshop_users');
    }

    public function faculties()
    {
        return $this->belongsToMany(Faculty::class, 'faculty_users');
    }

    public function importItems()
    {
        return $this->hasMany('App\Models\ImportItem');
    }

    /* Role related getters */

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_users')->withPivot('object_id');
    }

    /**
     * Decides if the user has any role of the given roles.
     *
     * @param  array  $roleNames  the roles' name
     * @param  int  $objectId  to filter the roles. Using with multiple roles is not recommended.
     * @return bool
     */
    public function hasAnyRole(array $roleNames, $objectId = null): bool
    {
        return $this->roles->contains(function ($value, $key) use ($roleNames, $objectId) {
            return in_array($value->name, $roleNames) && $value->pivot->object_id === $objectId;
        });
    }

    /**
     * Decides if the user has a role.
     * Object is recommended if the role has objects, otherwise use hasRoleBase function.
     *
     * @param  string  $roleName  the role's name
     * @param  int  $objectId  optional object id. For object names use hasRoleWithObjectName function.
     * @return bool
     */
    public function hasRole(string $roleName, $objectId = null): bool
    {
        return $this->hasAnyRole([$roleName], $objectId);
    }

    /**
     * Decides if the user has a role with an object.
     *
     * @param  string  $roleName  the role's name
     * @param  string  $objectName  the object's name. For multiple objects use hasRoleWithObjectNames function.
     * @return bool
     */
    public function hasRoleWithObjectName(string $roleName, string $objectName): bool
    {
        $objects = Role::possibleObjectsFor($roleName);
        $objectId = $objects->firstWhere('name', $objectName)->id;

        return $this->hasAnyRole([$roleName], $objectId);
    }

    /**
     * Decides if the user has a role with an object.
     *
     * @param  string  $roleName  the role's name
     * @param  array  $objectNames  array of the object names
     * @return bool
     */
    public function hasRoleWithObjectNames(string $roleName, array $objectNames): bool
    {
        foreach ($objectNames as $objectName) {
            if ($this->hasRoleWithObjectName($roleName, $objectName)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Scope a query to only include users with the given role.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $role  the role's name
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeRole($query, $role)
    {
        return $query->whereHas('roles', function ($q) use ($role) {
            $q->where('name', $role);
        });
    }

    /**
     * Decides if the user has any role with all possible object ids.
     */
    public function hasRoleBase(string $roleName): bool
    {
        $objects = Role::possibleObjectsFor($roleName);
        foreach ($objects as $object) {
            if ($this->hasRole($roleName, $object->id)) {
                return true;
            }
        }
        if ($this->hasRole($roleName)) {
            return true;
        }

        return false;
    }

    /**
     * Decides if the user has any role with elevated permissions.
     */
    public function hasElevatedPermissions(): bool
    {
        foreach ($this->roles as $role) {
            if ($role->hasElevatedPermissions()) {
                return true;
            }
        }

        return false;
    }

    public static function collegists()
    {
        return Role::getUsers(Role::COLLEGIST);
    }

    public function isCollegist(): bool
    {
        return $this->hasRoleBase(Role::COLLEGIST);
    }

    public function isInStudentsCouncil(): bool
    {
        return $this->hasRoleBase('student-council');
    }

    /**
     * @return User|null the president
     */
    public static function president()
    {
        return Role::getUsers(Role::STUDENT_COUNCIL, Role::PRESIDENT)->first();
    }

    /**
     * @return User|null the director
     */
    public static function director()
    {
        return Role::getUsers(Role::DIRECTOR)->first();
    }

    /**
     * @param  string  $roleObjectName  one of Role::COMMITTEE_LEADERS
     * @return User|null the committee leader
     */
    public static function committeeLeader($roleObjectName)
    {
        if (! in_array($roleObjectName, Role::COMMITTEE_LEADERS)) {
            throw new InvalidArgumentException($roleObjectName.' should be one of these: '.implode(', ', Role::COMMITTEE_LEADERS));
        }

        return Role::getUsers(Role::STUDENT_COUNCIL, $roleObjectName)->first();
    }

    /**
     * @return User|null the Communication Committe's leader
     */
    public static function communicationLeader()
    {
        return self::CommitteeLeader(Role::COMMUNICATION_LEADER);
    }

    /**
     * @return User|null the Cultural Committe's leader
     */
    public static function culturalLeader()
    {
        return self::CommitteeLeader(Role::CULTURAL_LEADER);
    }

    /**
     * @return User|null the Sport Committe's leader
     */
    public static function sportLeader()
    {
        return self::CommitteeLeader(Role::SPORT_LEADER);
    }

    /**
     * @return User|null the Science Committe's leader
     */
    public static function scienceLeader()
    {
        return self::CommitteeLeader(Role::SCIENCE_LEADER);
    }

    /**
     * @return User|null the Community Committe's leader
     */
    public static function communityLeader()
    {
        return self::CommitteeLeader(Role::COMMUNITY_LEADER);
    }

    /**
     * @return User|null the Communication Committe's leader
     */
    public static function economicLeader()
    {
        return self::CommitteeLeader(Role::ECONOMIC_LEADER);
    }

    public static function printers()
    {
        return Role::getUsers(Role::PRINTER);
    }

    /* Semester related getters */

    /**
     * Returns the semesters where the user has any status.
     */
    public function allSemesters()
    {
        return $this->belongsToMany(Semester::class, 'semester_status')->withPivot(['status', 'verified', 'comment']);
    }

    /**
     * Returns the semesters where the user has the given status.
     */
    public function semestersWhere($status)
    {
        return $this->belongsToMany(Semester::class, 'semester_status')
            ->wherePivot('status', '=', $status)
            ->withPivot('verified', 'comment');
    }

    /**
     * Returns the semesters where the user has the given status.
     */
    public function activeSemesters()
    {
        return $this->semestersWhere(Semester::ACTIVE);
    }

    /**
     * Decides if the user has any status in the semester.
     *
     * @param  int  $semester  semester id
     * @return bool
     */
    public function isInSemester($semester): bool
    {
        return $this->allSemesters->contains($semester);
    }

    /**
     * Decides if the user is active in the semester.
     *
     * @param  int  $semester  semester id
     * @return bool
     */
    public function isActiveIn($semester): bool
    {
        return $this->activeSemesters->contains($semester);
    }

    /**
     * Scope a query to only include active users in the given semester.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  int  $semester_id
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActiveIn($query, $semester_id)
    {
        return $query->whereHas('activeSemesters', function ($q) use ($semester_id) {
            $q->where('id', $semester_id);
        });
    }

    /**
     * Decides if the user is active in the current semester.
     *
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->isActiveIn(Semester::current());
    }

    /**
     * Decides if the user is a resident collegist currently.
     *
     * @return bool
     */
    public function isResident(): bool
    {
        return $this->hasRoleWithObjectName(Role::COLLEGIST, 'resident');
    }

    /**
     * Decides if the user is an extern collegist currently.
     *
     * @return bool
     */
    public function isExtern(): bool
    {
        return $this->hasRoleWithObjectName(Role::COLLEGIST, 'extern');
    }

    /**
     * Set the collegist to be resident.
     * Only applies for collegists.
     */
    public function setResident(): void
    {
        $this->setCollegistRole('resident');
    }

    /**
     * Set the collegist to be extern.
     * Only applies for collegists.
     */
    public function setExtern()
    {
        $this->setCollegistRole('extern');
    }

    /**
     * Set the collegist to be extern or resident.
     * Only applies for collegists.
     */
    private function setCollegistRole($objectName)
    {
        if ($this->isCollegist()) {
            $collegist_role = Role::getId(Role::COLLEGIST);
            $this->roles()->detach($collegist_role);
            $this->roles()->attach($collegist_role, ['object_id' => Role::getObjectIdByName(Role::COLLEGIST, $objectName)]);
        }
    }

    /**
     * Returns the collegist's status in the semester.
     *
     * @param $semester semester id
     * @return string the status. Returns INACTIVE if the user does not have any status in the given semester.
     */
    public function getStatusIn($semester): string
    {
        $semesters = $this->allSemesters;
        if (! $semesters->contains($semester)) {
            return Semester::INACTIVE;
        }

        return $semesters->find($semester)->pivot->status;
    }

    /**
     * Returns the collegist's status in the current semester.
     *
     * @return string the status. Returns INACTIVE if the user does not have any status.
     */
    public function getStatus(): string
    {
        return $this->getStatusIn(Semester::current());
    }

    /**
     * Sets the collegist's status for a semester.
     *
     * @param Semester the semester.
     * @param string the status
     * @param string optional comment
     * @return User the modified user
     */
    public function setStatusFor(Semester $semester, $status, $comment = null): User
    {
        $this->allSemesters()->syncWithoutDetaching([
            $semester->id => [
                'status' => $status,
                'comment' => $comment,
            ],
        ]);

        return $this;
    }

    /**
     * Sets the collegist's status for the current semester.
     *
     * @param string the status
     * @param string optional comment
     * @return User the modified user
     */
    public function setStatus($status, $comment = null)
    {
        return $this->setStatusFor(Semester::current(), $status, $comment);
    }

    /**
     * Verify the collegist's status for the semester.
     *
     * @param Semester the semester
     * @return User the modified user
     */
    public function verify($semester)
    {
        $this->allSemesters()->syncWithoutDetaching([
            $semester->id => [
                'verify' => true,
            ],
        ]);

        return $this;
    }

    public function transactions_payed()
    {
        return $this->hasMany('App\Models\Transaction', 'payer_id');
    }

    public function transactions_received()
    {
        return $this->hasMany('App\Models\Transaction', 'receiver_id');
    }

    /**
     * Scope a query to only include users who has to pay kkt or netreg in the given semester.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  int  $semester_id
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeHasToPayKKTNetregInSemester($query, $semester_id)
    {
        return $query->role(Role::COLLEGIST)->activeIn($semester_id)
            ->whereDoesntHave('transactions_payed', function ($query) use ($semester_id) {
                $query->where('semester_id', $semester_id);
                $query->whereIn('payment_type_id', [PaymentType::kkt()->id, PaymentType::netreg()->id]);
            });
    }

    /**
     * Returns the payed kkt amount in the semester. 0 if has not payed kkt.
     */
    public function payedKKTInSemester(Semester $semester): int
    {
        $transaction = $this->transactions_payed()
            ->where('payment_type_id', PaymentType::kkt()->id)
            ->where('semester_id', $semester->id)
            ->get();

        return $transaction ? $transaction->amount : 0;
    }

    /**
     * Returns the payed kkt amount in the current semester. 0 if has not payed kkt.
     */
    public function payedKKT(): int
    {
        return $this->payedKKTInSemester(Semester::current());
    }

    public static function notifications()
    {
        return self::withoutGlobalScope('verified')->where('verified', false)->count();
    }

    /**
     * Mr and Miss functions.
     */
    public function mrAndMissVotesGiven()
    {
        return $this->hasMany('App\Models\MrAndMissVote', 'voter');
    }

    public function mrAndMissVotesGot()
    {
        return $this->hasMany('App\Models\MrAndMissVote', 'votee');
    }

    public function votedFor($category)
    {
        $votes = $this->mrAndMissVotesGiven()
        ->where('category', $category->id)
        ->where('semester', Semester::current()->id);
        if ($votes->count() > 0) {
            return ['voted' => true, 'vote' => $votes->first()];
        }

        return ['voted' => false];
    }
}
