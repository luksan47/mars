<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
     *      payed kkt * (isResident ? 0.6 : 0.45) / member's workshops' count
     */
    public static function generateBalances($semester_id)
    {
        $workshops = Workshop::with('users:id')->get();

        if (!self::where('semester_id', $semester_id)->count()) {
            $balances = [];
            foreach ($workshops as $workshop) {
                $balances[] = [
                    'semester_id' => $semester_id,
                    'workshop_id' => $workshop->id
                ];
            }

            self::insert($balances);
        }

        $users_has_to_pay_kktnetreg = User::hasToPayKKTNetregInSemester($semester_id)->pluck('id', 'id')->toArray();
        $active_users = User::activeIn($semester_id)->with(['roles' => function ($q) {
            $q->where('name', Role::COLLEGIST);
        }, 'workshops:id'])->get()->keyBy('id')->all();

        foreach ($workshops as $workshop) {
            $balance = 0;
            $resident = 0;
            $extern = 0;
            $not_yet_paid = 0;
            foreach ($workshop->users as $member) {
                if (isset($active_users[$member->id])) {
                    if (!isset($users_has_to_pay_kktnetreg[$member->id])) {
                        $user = $active_users[$member->id];
                        $amount = config('custom.kkt');
                        if ($user->isResident()) {
                            $amount *= config('custom.workshop_balance_resident');
                            $resident++;
                        } else {
                            $amount *= config('custom.workshop_balance_extern');
                            $extern++;
                        }
                        $balance += $amount / $user->workshops->count();
                    } else {
                        $not_yet_paid++;
                    }
                }
            }
            self::where(['semester_id' => $semester_id, 'workshop_id' => $workshop->id])
                ->update([
                    'allocated_balance' => $balance,
                    'extern' => $extern,
                    'resident' => $resident,
                    'not_yet_paid' => $not_yet_paid
                ]);
        }
    }
}
