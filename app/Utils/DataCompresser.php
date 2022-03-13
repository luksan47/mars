<?php

namespace App\Utils;

class DataCompresser
{
    const DELIMETER = '|';

    /**
     * Compress an array to a delimeter separated string.
     *
     * @author @hamaren2517
     * @param array $array
     * @return string|null $string
     */
    public static function compressData($array)
    {
        if ($array === null) {
            return null;
        }

        return join(
            self::DELIMETER,
            array_map(
                function ($item) {
                    return str_replace(self::DELIMETER, ' ', $item);
                },
                array_filter($array, function ($item) {
                    return $item !== null;
                })
            )
        );
    }

    /**
     * Decompress a delimeter separated string into an array.
     *
     * @author @hamaren2517
     * @param array $array
     * @return string|null $string
     */
    public static function decompressData($string)
    {
        if ($string === null) {
            return null;
        }

        return explode(self::DELIMETER, $string);
    }
}

