<?php

namespace App\Http\Controllers;

use App\Router;

class RouterController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:internet.internet');
    }

    public function index()
    {
        $this->authorize('viewAny', Router::class);

        $routers = Router::all()->sortBy('room');

        return view('admin.routers.list')->with('routers', $routers);
    }

    public function view($ip)
    {
        $router = Router::findOrFail($ip);

        return view('admin.routers.view')->with('router', $router);
    }
}
