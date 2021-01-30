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
        'uploader_id',
        'title',
        'subtitle',
        'description',
        'further_details_url',
        'website_url',
        'facebook_event_url',
        'fill_url',
        'registration_url',
        'registration_deadline',
        'filling_deadline',
        'date',
        'time',
        'end_date',
        'picture_path',
        'sent',
    ];
    protected $dates = ['date', 'time', 'end_date', 'valid_until', 'registration_deadline', 'filling_deadline'];

    //notifications should be sent before this date
    public function getValidUntilAttribute()
    {
        $date = (($this->registration_deadline ?? $this->filling_deadline) ?? $this->date);
        if ($date) {
            return $date->format('Y.m.d');
        }

        return null;
    }

    public function getDateTimeAttribute()
    {
        if ($this->date == null) {
            return null;
        }

        $datetime = $this->date->format('Y.m.d.');
        if ($this->time) {
            $datetime .= $this->time->format(' h:m');
        } elseif ($this->end_date) {
            $datetime .= $this->end_date->format(' - Y.m.d.');
        }

        return $datetime;
    }

    public function shouldBeSent()
    {
        return ($this->valid_until != null)
            && (now()->addDays(3)->format('Y.m.d') > $this->valid_until)
            && ! $this->sent;
    }

    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploader_id');
    }
}
