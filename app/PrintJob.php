<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PrintJob extends Model
{
    protected $table = 'print_jobs';
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = true;

    const QUEUED = "QUEUED";
    const ERROR = "ERROR";
    const CANCELLED = "CANCELLED";
    const COMPLETED = "COMPLETED";
    const STATES = [
        self::QUEUED,
        self::ERROR,
        self::CANCELLED,
        self::COMPLETED,
    ];

    protected $fillable = [
        'filename', 'filepath', 'user_id', 'state', 'job_id', 'cost'
    ];
    
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    
    public static function translateStates(): \Closure
    {
        return function ($data) {
            $data->state = __('print.' . strtoupper($data->state));
            return $data;
        };
    }

    public static function addCurrencyTag(): \Closure
    {
        return function ($data) {
            $data->cost = "{$data->cost} HUF";
            return $data;
        };
    }
}
