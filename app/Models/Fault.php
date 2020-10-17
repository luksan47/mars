<?php

namespace App\Models;

use App\Utils\NotificationCounter;
use Illuminate\Database\Eloquent\Model;

class Fault extends Model
{
    use NotificationCounter;

    public $incrementing = true;
    public $timestamps = true;
    protected $fillable = [
        'reporter_id',
        'location',
        'description',
        'status',
        'created_at',
        'updated_at',
    ];

    const UNSEEN = 'UNSEEN';
    const SEEN = 'SEEN';
    const DONE = 'DONE';
    const WONT_FIX = 'WONT_FIX';
    const STATES = [self::UNSEEN, self::SEEN, self::DONE, self::WONT_FIX];

    public static function getState($value)
    {
        return strtoupper($value);
    }

    public static function notifications()
    {
        return self::where('status', self::UNSEEN)->count();
    }

    public function reporter()
    {
        return $this->belongsTo('App\Models\User', 'reporter_id', 'id');
    }
}
