<?php

namespace App\Models;

use App\Utils\DataCompresser;
use Illuminate\Database\Eloquent\Model;

class ApplicationForm extends Model
{
    protected $table = 'application_forms';

    protected $fillable = [
        'user_id',
        'status',
        'high_school_address',
        'graduation_average',
        'semester_average',
        'language_exam',
        'competition',
        'publication',
        'foreign_studies',
        'question_1',
        'question_2',
        'question_3',
        'question_4',
    ];

    public const STATUS_IN_PROGRESS = 'in_progress';
    public const STATUS_SUBMITTED = 'submitted';
    public const STATUS_BANISHED = 'banished';

    public const STATUSES = [
        self::STATUS_IN_PROGRESS,
        self::STATUS_SUBMITTED,
        self::STATUS_BANISHED,
    ];

    /*
    |--------------------------------------------------------------------------
    | Relations
    |--------------------------------------------------------------------------
    */

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function files()
    {
        return $this->hasMany('App\Models\File');
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors & Mutators
    |--------------------------------------------------------------------------
    */

    public function getSemesterAverageAttribute($value)
    {
        return DataCompresser::decompressData($value);
    }

    public function setSemesterAverageAttribute($value)
    {
        $this->attributes['semester_average'] = DataCompresser::compressData($value);
    }

    public function getLanguageExamAttribute($value)
    {
        return DataCompresser::decompressData($value);
    }

    public function setLanguageExamAttribute($value)
    {
        $this->attributes['language_exam'] = DataCompresser::compressData($value);
    }

    public function getCompetitionAttribute($value)
    {
        return DataCompresser::decompressData($value);
    }

    public function setCompetitionAttribute($value)
    {
        $this->attributes['competition'] = DataCompresser::compressData($value);
    }

    public function getPublicationAttribute($value)
    {
        return DataCompresser::decompressData($value);
    }

    public function setPublicationAttribute($value)
    {
        $this->attributes['publication'] = DataCompresser::compressData($value);
    }

    public function getForeignStudiesAttribute($value)
    {
        return DataCompresser::decompressData($value);
    }

    public function setForeignStudiesAttribute($value)
    {
        $this->attributes['foreign_studies'] = DataCompresser::compressData($value);
    }

    /*
    |--------------------------------------------------------------------------
    | Public functions
    |--------------------------------------------------------------------------
    */

    public function isReadyToSubmit()
    {
        $educationalInformation = $this->user->educationalInformation;

        if (! isset($educationalInformation)) {
            return false;
        }

        if (! isset($this->user->profilePicture)) {
            return false;
        }
        if (count($this->files) < 2) {
            return false;
        }

        if ($this->user->workshops->count() == 0) {
            return false;
        }
        if ($this->user->faculties->count() == 0) {
            return false;
        }

        if (! $this->user->isResident() && ! $this->user->isExtern()) {
            return false;
        }

        if (! isset($educationalInformation->year_of_graduation)) {
            return false;
        }
        if (! isset($educationalInformation->high_school)) {
            return false;
        }
        if (! isset($educationalInformation->neptun)) {
            return false;
        }
        if (! isset($educationalInformation->year_of_acceptance)) {
            return false;
        }
        if (! isset($educationalInformation->email)) {
            return false;
        }
        if (! isset($educationalInformation->program)) {
            return false;
        }

        if (! isset($this->high_school_address)) {
            return false;
        }
        if (! isset($this->graduation_average)) {
            return false;
        }
        if (! isset($this->question_1)) {
            return false;
        }
        if (! isset($this->question_2)) {
            return false;
        }
        if (! isset($this->question_3)) {
            return false;
        }

        return true;
    }

}
