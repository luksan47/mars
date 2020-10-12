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
                        ($member->isResident() ? 0.6 : 0.45 ) /
                        $member->workshops->count();
                }
            }
            DB::table('workshop_balances')
                ->updateOrInsert(
                    ['semester_id' => Semester::current()->id, 'workshop_id' => $workshop->id],
                    ['allocated_balance' => $balance]
                );
        }
    }
}
