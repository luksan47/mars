<?php

namespace App;

use App\Course;
use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'number',
        'capacity',
    ];

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'timetable')
                    ->using('App\Timetable')
                    ->withPivot('time')
                    ->withTimestamps();
    }

}
