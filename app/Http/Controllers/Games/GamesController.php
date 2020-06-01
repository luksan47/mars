<?php

namespace App\Http\Controllers\Games;

use App\Http\Controllers\Controller;
use App\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GamesController extends Controller
{
    public function index()
    {
        return view('games.app');
    }

}
