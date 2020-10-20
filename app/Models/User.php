<?php

namespace App\Models;

use App\Utils\NotificationCounter;
use Illuminate\Contracts\Translation\HasLocalePreference;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

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

    /**
     * Get the user's preferred locale.
     *
     * @return string
     */
    public function preferredLocale()
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

    public function sumOfActiveFreePages()
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

    public function numberOfPrintedDocuments()
    {
        return $this->hasMany('App\Models\PrintAccountHistory')
            ->where('balance_change', '<', 0)
            ->orWhere('free_page_change', '<', 0)
            ->count();
    }

    public function spentBalance()
    {
        return abs($this->hasMany('App\Models\PrintAccountHistory')
            ->where('balance_change', '<', 0)
            ->sum('balance_change'));
    }

    public function spentFreePages()
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

    /* Basic information of the user */

    public function setVerified()
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

    public function hasRoleWithObjectName(string $roleName, string $objectName)
    {
        $objects = Role::possibleObjectsFor($roleName);
        $objectId = $objects->firstWhere('name', $objectName)->id;

        return $this->hasAnyRole([$roleName], $objectId);
    }

    public function hasRoleWithObjectNames(string $roleName, array $objectNames)
    {
        foreach ($objectNames as $objectName) {
            if ($this->hasRoleWithObjectName($roleName, $objectName)) {
                return true;
            }
        }

        return false;
    }

    public function scopeRole($query, $role)
    {
        return $query->whereHas('roles', function ($q) use ($role) {
            $q->where('name', $role);
        });
    }

    // Has any role with all possible object ID
    public function hasRoleBase(string $roleName)
    {
        $objects = Role::possibleObjectsFor($roleName);
        foreach ($objects as $object) {
            if ($this->hasRole($roleName, $object->id)) {
                return true;
            }
        }

        return false;
    }

    public function hasElevatedPermissions()
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

    public function isCollegist()
    {
        return $this->hasRoleBase(Role::COLLEGIST);
    }

    public function isInStudentsCouncil()
    {
        return $this->hasRoleBase('student-council');
    }

    public static function printers()
    {
        return Role::getUsers(Role::PRINTER);
    }

    public static function internetUsers()
    {
        return Role::getUsers(Role::INTERNET_USER);
    }

    /* Semester related getters */

    public function allSemesters()
    {
        return $this->belongsToMany(Semester::class, 'semester_status')->withPivot(['status', 'verified', 'comment']);
    }

    public function semestersWhere($status)
    {
        return $this->belongsToMany(Semester::class, 'semester_status')
                    ->wherePivot('status', '=', $status)
                    ->withPivot('verified', 'comment');
    }

    public function activeSemesters()
    {
        return $this->semestersWhere(Semester::ACTIVE);
    }

    public function isInSemester($semester)
    {
        return $this->allSemesters->contains($semester);
    }

    public function isActiveIn($semester)
    {
        return $this->activeSemesters->contains($semester);
    }

    public function isActive()
    {
        return $this->isActiveIn(Semester::current());
    }

    public function isResident()
    {
        return $this->hasRoleWithObjectName(Role::COLLEGIST, 'resident');
    }

    public function isExtern()
    {
        return $this->hasRoleWithObjectName(Role::COLLEGIST, 'extern');
    }

    public function setResident()
    {
        $this->setCollegistRole('resident');
    }

    public function setExtern()
    {
        $this->setCollegistRole('extern');
    }

    private function setCollegistRole($objectName)
    {
        if ($this->isCollegist()) {
            $collegist_role = Role::getId(Role::COLLEGIST);
            $this->roles()->detach($collegist_role);
            $this->roles()->attach($collegist_role, ['object_id' => Role::getObjectIdByName(Role::COLLEGIST, $objectName)]);
        }
    }

    public function getStatusIn($semester)
    {
        $semesters = $this->allSemesters;
        if (! $semesters->contains($semester)) {
            return Semester::INACTIVE;
        }

        return $semesters->find($semester)->pivot->status;
    }

    public function getStatus()
    {
        return $this->getStatusIn(Semester::current());
    }

    public function setStatusFor($semester, $status, $comment = null)
    {
        $this->allSemesters()->syncWithoutDetaching([
            $semester->id => [
                'status' => $status,
                'comment' => $comment,
            ],
        ]);

        return $this;
    }

    public function setStatus($status, $comment = null)
    {
        return $this->setStatusFor(Semester::current(), $status, $comment);
    }

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

    public function hasToPayKKTNetreg()
    {
        return $this->hasToPayKKTNetregInSemester(Semester::current());
    }

    public function hasToPayKKTNetregInSemester($semester)
    {
        if (! $this->isActiveIn($semester)) {
            return false;
        }

        $payed_kktnetreg = $this->transactions_payed()
            ->where('semester_id', $semester->id)
            ->where(function ($query) {
                $query->where('payment_type_id', PaymentType::where('name', 'KKT')->firstOrFail()->id)
                      ->orWhere('payment_type_id', PaymentType::where('name', 'NETREG')->firstOrFail()->id);
            })->get();

        return $payed_kktnetreg->count() == 0;
    }

    public function KKTPayedInSemester($semester)
    {
        if ($this->hasToPayKKTNetregInSemester($semester)) {
            return 0;
        }

        return $semester->transactions()
            ->where('payment_type_id', PaymentType::where('name', 'KKT')->firstOrFail()->id)
            ->where('payer_id', $this->id)
            ->first();
    }

    public static function notifications()
    {
        return self::where('verified', false)->count();
    }
}
