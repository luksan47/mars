<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Domino extends Model
{
    protected $table = 'game_domino';

    const CREATE = 'CREATE';
    const PLACE = 'PLACE';
    const UNDO = 'UNDO';
    const CHANGE_TURN = 'CHANGE_TURN';
    const STATES = [self::CREATE, self::PLACE, self::UNDO, self::CHANGE_TURN];

    public function owner()
    {
        return $this->belongsTo('App\User', 'owner', 'id');
    }
    
    public function players()
    {
        return $this->hasMany(User::class, 'game_domino_players', 'game_id', 'player');
    }
}
