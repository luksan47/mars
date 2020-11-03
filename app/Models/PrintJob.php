<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrintJob extends Model
{
    use HasFactory;

    protected $table = 'print_jobs';
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = true;

    const QUEUED = 'QUEUED';
    const ERROR = 'ERROR';
    const CANCELLED = 'CANCELLED';
    const SUCCESS = 'SUCCESS';
    const STATES = [
        self::QUEUED,
        self::ERROR,
        self::CANCELLED,
        self::SUCCESS,
    ];

    protected $fillable = [
        'filename', 'filepath', 'user_id', 'state', 'job_id', 'cost',
    ];

    protected $appends = ['origin_state'];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public static function translateStates(): \Closure
    {
        return function ($data) {
            $data->state = __('print.'.strtoupper($data->state));

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

    public function getOriginStateAttribute()
    {
        return strtoupper($this->state);
    }
}
