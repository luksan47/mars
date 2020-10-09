<?php

namespace App\Utils;

trait NotificationCounter
{
    public static $cacheSeconds = 60;

    public static function cacheKey()
    {
        $reflection = new \ReflectionClass(static::class);

        return strtolower($reflection->getShortName());
    }

    /**
     * Returns a number, based on the objects the user should be notified about.
     */
    abstract public static function notifications();
}
