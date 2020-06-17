<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\Pivot;

class Timetable extends Pivot
{
    protected $table = 'timetable';
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'time',
    ];

    protected $casts = [
        'time' => 'datetime',
    ];

    public function course()
    {
        return $this->belongsTo('App\Course');
    }

    public function classroom()
    {
        return $this->belongsTo('App\Classroom');
    }

    // Only for testing
    public function isToday()
    {
        $dt = Carbon::instance($this->time);

        return $dt->isToday();
    }
}
