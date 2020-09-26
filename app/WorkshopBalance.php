<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WorkshopBalance extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'semester_id',
        'workshop_id',
        'allocated_balance',
        'used_balance'
    ];

    public function workshop()
    {
        return $this->belongsTo('App\Workshop');
    }

    public function semester()
    {
        return $this->belongsTo('App\Semester');
    }
}