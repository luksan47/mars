<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\Semester;
use App\Models\Workshop;

class WorkshopBalance extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'semester_id',
        'workshop_id',
        'allocated_balance',
        'used_balance',
    ];

    public function workshop()
    {
        return $this->belongsTo('App\Models\Workshop');
    }

    public function semester()
    {
        return $this->belongsTo('App\Models\Semester');
    }

    public function membersPayedKKTNetreg()
    {
        return $this->payedKKTNetregInSemester(Semester::current());
    }

    public function membersPayedKKTNetregInSemester(Semester $semester)
    {
        return $this->workshop->users->filter(function ($user, $key) use ($semester) {
            return $user->isActiveIn($semester) && (! $user->hasToPayKKTNetregInSemester($semester));
        });
    }

    /**
     * Generates all the workshops' allocated balance in the current semester.
     * For all active members in a workshop who payed kkt: 
     *      kkt * (isResident ? 0.6 : 0.45) / member's workshops' count
    */
    public static function generateBalances()
    {
        foreach(Workshop::all() as $workshop)
        {
            $balance = 0;
            foreach ($workshop->users as $member) {
                if ($member->isActive() && !$member->hasToPayKKTNetreg())
                {
                    $balance += config('custom.kkt') *
                        ($member->isResident() ? config('custom.workshop_balance_resident') : config('custom.workshop_balance_extern') ) /
                        $member->workshops->count();
                }
            }
            self::updateOrInsert(
                ['semester_id' => Semester::current()->id, 'workshop_id' => $workshop->id],
                ['allocated_balance' => $balance]
            );
        }
    }

    public function payCountDisplayString(Semester $semester)
    {
        $workshop = $this->workshop;
        $payed_members = $this->membersPayedKKTNetregInSemester($semester);
        $payed_residents = $payed_members->filter(function($user, $key){
            return $user->isResident();
        })->count();
        $payed_externs = $payed_members->filter(function($user, $key){
            return $user->isExtern();
        })->count();
        $not_payed = $workshop->users->filter(function ($user, $key) use ($semester) {
            return ($user->hasToPayKKTNetregInSemester($semester));
        })->count();
        return $payed_residents . ' - ' . $payed_externs . ' (+' . $not_payed . ')';
    }
}
