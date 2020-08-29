<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ImportItem extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'name', 'user_id'
    ];


}
