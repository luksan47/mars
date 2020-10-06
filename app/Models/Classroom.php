<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'name',
        'capacity',
    ];

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'timetable')
                    ->using('App\Models\Timetable')
                    ->withPivot('time')
                    ->withTimestamps();
    }
}
