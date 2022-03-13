<?php

namespace App\Models;

use App\Utils\DataCompresser;
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
        'program',
    ];

    protected const DELIMETER = '|';

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function getProgramAttribute($value)
    {
        return DataCompresser::decompressData($value);
    }

    public function getProgramsAttribute(): string
    {
        if ($this->program === null) {
            return '';
        }

        return join(', ', $this->program);
    }

    public function setProgramAttribute($value)
    {
        $this->attributes['program'] = DataCompresser::compressData($value);
    }
}
