<?php

namespace App\Http\Controllers\Games;

use App\Http\Controllers\Controller;
use App\Role;
use App\Domino;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DominoController extends Controller
{
    public function create()
    {
        $domino = Domino::create([
            'game_id' => 0,

        ]);
        GAME D UPDATE
    }

}
