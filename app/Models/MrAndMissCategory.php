<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MrAndMissCategory extends Model
{
    public $timestamps = true;

    protected $fillable = [
        'title', 'mr', 'created_by', 'hidden', 'public', 'custom',
    ];
}
