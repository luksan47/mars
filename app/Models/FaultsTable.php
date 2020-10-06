<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FaultsTable extends Model
{
    const UNSEEN = 'UNSEEN';
    const SEEN = 'SEEN';
    const DONE = 'DONE';
    const WONT_FIX = 'WONT_FIX';
    const STATES = [self::UNSEEN, self::SEEN, self::DONE, self::WONT_FIX];

    public static function getState($value)
    {
        return strtoupper($value);
    }
}
