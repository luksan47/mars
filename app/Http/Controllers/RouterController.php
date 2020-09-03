<?php

namespace App\Http\Controllers;

use App\Router;

class RouterController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', Router::class);

        $routers = Router::all()->sortBy('room');

        return view('admin.routers')->with('routers', $routers);
    }
}
