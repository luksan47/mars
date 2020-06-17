<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'code',
        'workshop_id',
        'name',
        'name_english',
        'type',
        'credits',
        'hours',
        'semester_id',
        'teacher_id',
    ];

    const TYPE_SEMINAR = 'SEMINAR';
    const TYPE_LECTURE = 'LECTURE';
    const TYPE_PRACTICE = 'PRACTICE';
    const TYPES = [
        self::TYPE_SEMINAR,
        self::TYPE_LECTURE,
        self::TYPE_PRACTICE,
    ];

    // A course can be held in multiple classrooms, or in the same, but multiple times.
    public function classrooms()
    {
        return $this->belongsToMany(Classroom::class, 'timetable')
                    ->using('App\Timetable')
                    ->withPivot('time')
                    ->withTimestamps();
    }
}
