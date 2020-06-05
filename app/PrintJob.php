<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PrintJob extends Model
{
    protected $table = 'print_jobs';
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'filename', 'filepath', 'user', 'state', 'job_id', 'cost',
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
