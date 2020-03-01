<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EducationalInformation extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'year_of_graduation',
        'high_school',
        'neptun',
        'year_of_acceptance',
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
