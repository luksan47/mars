<?php

namespace App\Http\Controllers\Network;

use App\Models\Router;
use App\Http\Controllers\Controller;

class RouterController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:possess,App\Models\InternetAccess');
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
