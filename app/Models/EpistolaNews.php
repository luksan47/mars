<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EpistolaNews extends Model
{
    use HasFactory;

    protected $table = 'epistola';

    public $timestamps = false;

    protected $fillable = [
        'title',
        'subtitle',
        'description', //main text
        'further_details',
        'website',
        'facebook_event',
        'registration',
        'registration_deadline',
        'filling_deadline',
        'date',
        'end_date', //time interval if both provided
        'picture', //path to main picture
        'valid_until', //notifications should be sent before this date
    ];
}
