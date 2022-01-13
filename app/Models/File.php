<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $table = 'files';

    protected $fillable = [
        'user_id',
        'application_form_id', //if belongs to an application
        'name',
        'path',
    ];
}
