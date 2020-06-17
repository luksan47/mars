<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class Timetable extends Pivot
{
    protected $table = 'timetable';
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'user_id',
        'amount',
        'deadline',
        'last_modified_by',
        'comment',
    ];
}
