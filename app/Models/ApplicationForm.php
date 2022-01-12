<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApplicationForm extends Model
{
    protected $table = 'application_forms';

    protected $fillable = [
        'user_id',
        'high_school_address',
        'graduation_avarage',
        'semester_avarage',
        'language_exam',
        'competition',
        'publication',
        'foreign_studies',
        'question_1',
        'question_2',
        'question_3',
        'question_4',
    ];

    protected const DELIMETER = '|';

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function files()
    {
        return $this->hasMany('App\Models\AplicationFile');
    }

    public function getSemesterAvarageAttribute($value)
    {
        return self::decompressData($value);
    }

    public function setSemesterAvarageAttribute($value)
    {
        $this->attributes['semester_avarage'] = self::compressData($value);
    }

    public function getLanguageExamAttribute($value)
    {
        return self::decompressData($value);
    }

    public function setLanguageExamAttribute($value)
    {
        $this->attributes['language_exam'] = self::compressData($value);
    }

    public function getCompetitionAttribute($value)
    {
        return self::decompressData($value);
    }

    public function setCompetitionAttribute($value)
    {
        $this->attributes['competition'] = self::compressData($value);
    }

    public function getPublicationAttribute($value)
    {
        return self::decompressData($value);
    }

    public function setPublicationAttribute($value)
    {
        $this->attributes['publication'] = self::compressData($value);
    }

    public function getForeignStudiesAttribute($value)
    {
        return self::decompressData($value);
    }

    public function setForeignStudiesAttribute($value)
    {
        $this->attributes['foreign_studies'] = self::compressData($value);
    }

    private static function compressData($array)
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

    private static function decompressData($string)
    {
        if ($string === null) {
            return null;
        }

        return explode(self::DELIMETER, $string);
    }
}
