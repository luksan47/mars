<?php

namespace App\Models;

use App\Utils\NotificationCounter;
use Illuminate\Database\Eloquent\Model;

class Faults extends Model
{
    use NotificationCounter;

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
}
