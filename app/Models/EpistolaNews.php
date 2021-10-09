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
        'date',
        'time',
        'end_date',
        'details_name_1',
        'details_name_2',
        'details_url_1',
        'details_url_2',
        'deadline_name',
        'deadline_date',
        'picture_path',
        'date_for_sorting',
        'category',
        'sent',
    ];
    protected $dates = ['date', 'time', 'end_date', 'date_for_sorting', 'valid_until', 'deadline_date'];

    //notifications should be sent before this date
    public function getValidUntilAttribute()
    {
        $date = ($this->deadline_date ?? $this->date);
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
            $datetime .= $this->time->format(' G:i');
        } elseif ($this->end_date) {
            $datetime .= $this->end_date->format(' - Y.m.d.');
        }

        return $datetime;
    }

    public function getColorAttribute()
    {
        //yiq algorithm     
        $r = hexdec(substr($this->bg_color, 1, 2));
        $g = hexdec(substr($this->bg_color, 3, 2));
        $b = hexdec(substr($this->bg_color, 5, 2));
        $yiq = (($r * 299) + ($g * 587) + ($b * 114)) / 1000;
        return ($yiq >= 128) ? 'black' : 'white';
    }

    public function getBgColorAttribute()
    {
        //generate color from category string
        return substr(dechex(crc32($this->category)), 0, 6);
    }

    public function shouldBeSent()
    {
        return ($this->valid_until != null)
            && (now()->addDays(7)->format('Y.m.d') > $this->valid_until)
            && ! $this->sent;
    }

    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploader_id');
    }
}
