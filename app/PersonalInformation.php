<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PersonalInformation extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'place_of_birth',
        'date_of_birth',
        'mothers_name',
        'phone_number',
        'country',
        'county',
        'zip_code',
        'city',
        'street_and_number',
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function getAddress()
    {
        return $this->country.', '.$this->zip_code.' '.$this->city.', '.$this->street_and_number;
    }

    public function getPlaceAndDateOfBirth()
    {
        return $this->place_of_birth.', '.$this->date_of_birth;
    }
}
