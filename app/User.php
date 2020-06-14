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

    /* Printing related getters */

    public function printAccount()
    {
        return $this->hasOne('App\PrintAccount');
    }

    public function freePages()
    {
        return $this->hasMany('App\FreePages');
    }

    public function sumOfActiveFreePages()
    {
        return $this->freePages
                    ->where('deadline', '>', \Carbon\Carbon::now())
                    ->sum('amount');
    }

    public function printHistory()
    {
        return $this->hasMany('App\PrintAccountHistory');
    }

    public function printJobs()
    {
        return $this->hasMany('App\PrintJob');
    }

    /* Internet module related getters */

    public function internetAccess()
    {
        return $this->hasOne('App\InternetAccess');
    }

    public function macAddresses()
    {
        return $this->hasMany('App\MacAddress');
    }

    /* Basic information of the user */

    public function personalInformation()
    {
        return $this->hasOne('App\PersonalInformation');
    }

    public function educationalInformation()
    {
        return $this->hasOne('App\EducationalInformation');
    }

    public function workshops()
    {
        return $this->belongsToMany(Workshop::class, 'workshop_users');
    }

    public function faculties()
    {
        return $this->belongsToMany(Faculty::class, 'faculty_users');
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
        return getStatusIn(Semester::current());
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

    /**
     * @deprecated use hasRole instead
     */
    public function isAdmin()
    {
        trigger_error('Method '.__METHOD__.' is deprecated', E_USER_DEPRECATED);

        return $this->hasRole(['admin']);
    }
}
