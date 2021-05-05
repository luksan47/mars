<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MrAndMissVote extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'voter', 'category', 'votee_id', 'votee_name', 'semester',
    ];
}
