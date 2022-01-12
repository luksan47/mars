<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApplicationFile extends Model
{
    protected $table = 'application_files';

    protected $fillable = [
        'application_form_id',
        'name',
        'path',
    ];
}
