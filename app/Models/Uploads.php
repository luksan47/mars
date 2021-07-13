<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Uploads extends Model
{
    public $timestamps = true;
    protected $primaryKey = 'id';

    public $fillable = [
        'id',
        'applications_id',

        'file_name',    // string
        'file_path',    // string
    ];

    public function applications()
    {
        return $this->belongsTo('App\Applications');
    }
}
