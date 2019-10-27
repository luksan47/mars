<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class RoomReservation extends Authenticatable
{
    protected $table = 'room_reservation';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'first_name', 'last_name', 'start_date','end_date',
    ];

    /**
     * The model's default values for attributes.
     */
}
