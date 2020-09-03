<?php

namespace App\Http\Controllers;

use App\Router;
use App\User;

class RouterController extends Controller
{
    public function index()
    {
        $routers = Router::all()->sortBy('room');
        return view('admin.routers')->with('routers', $routers);
    }
}
