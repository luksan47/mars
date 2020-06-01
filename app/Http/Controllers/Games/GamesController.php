<?php

namespace App\Http\Controllers\Games;

use App\Http\Controllers\Controller;

class GamesController extends Controller
{
    public function index()
    {
        return view('games.app');
    }
}
