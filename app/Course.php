<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    
    const TYPE_SEMINAR = "SEMINAR";
    const TYPE_LECTURE = "LECTURE";
    const TYPE_PRACTICE = "PRACTICE";
    const TYPES = [
        self::TYPE_SEMINAR,
        self::TYPE_LECTURE,
        self::TYPE_PRACTICE,
    ];
    
}
