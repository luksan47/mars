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

    const TYPE_SEMINAR = 'seminar';
    const TYPE_LECTURE = 'lecture';
    const TYPE_PRACTICE = 'practice';
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

    public static function types()
    {
        // Return a collection that can be handled by utils/select
        $types = [];
        for ($i = 0; $i < count(self::TYPES); $i++) {
            array_push($types, (object) ['id' => $i, 'name' => __('secretariat.'.self::TYPES[$i])]);
        }

        return collect($types);
    }
}
