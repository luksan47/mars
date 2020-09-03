<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Router extends Model
{
    protected $table = 'routers';
    protected $primaryKey = 'ip';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'ip', 'room', 'failed_for', // TODO: add more properties
    ];

    public function isDown()
    {
        return $this->failed_for > 0;
    }

    public function isUp()
    {
        return $this->failed_for == 0;
    }

    public function getFailStartDate()
    {
        return Carbon::now()->subMinutes($this->failed_for * 5);
    }
}
