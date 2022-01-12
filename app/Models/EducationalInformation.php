<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EducationalInformation extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'year_of_graduation',
        'high_school',
        'neptun',
        'year_of_acceptance',
        'email',
        'program'
    ];

    protected const DELIMETER = '|';

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function getProgramAttribute($value)
    {
        return self::decompressData($value);
    }

    public function setProgramAttribute($value)
    {
        $this->attributes['program'] = self::compressData($value);
    }

    private static function compressData($array)
    {
        if($array === null) return null;
        return join(
            self::DELIMETER,
            array_map(
                function($item) { return str_replace(self::DELIMETER, ' ', $item); },
                array_filter($array, function($item) { return $item !== null; })
            )
        );
    }

    private static function decompressData($string)
    {
        if($string === null) return null;
        return explode(self::DELIMETER, $string);
    }
}
