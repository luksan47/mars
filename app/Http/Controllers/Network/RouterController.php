<?php

namespace App\Http\Controllers\Network;

use App\Http\Controllers\Controller;
use App\Models\Router;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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

        return view('network.routers.list', ['routers' => $routers]);
    }

    public function view(Router $ip)
    {
        $this->authorize('view', $ip);

        return view('network.routers.view', ['router' => $ip]);
    }

    public function create()
    {
        $this->authorize('create', Router::class);

        return view('network.routers.create');
    }

    public function store(Request $request)
    {
        $this->authorize('create', Router::class);

        Validator::make($request->all(), [
            'ip' => 'required|max:15|unique:routers,ip',
            'room' => 'required|integer',
            'mac_WAN' => ['nullable', 'regex:/^(([a-f0-9]{2}[-:]){5}([a-f0-9]{2}))$/i'],
            'mac_2G_LAN' => ['nullable', 'regex:/^(([a-f0-9]{2}[-:]){5}([a-f0-9]{2}))$/i'],
            'mac_5G' => ['nullable', 'regex:/^(([a-f0-9]{2}[-:]){5}([a-f0-9]{2}))$/i'],
            'comment' => 'max:255',
        ])->validate();

        Router::create($request->all());

        return redirect(route('routers'));
    }

    public function edit(Router $ip)
    {
        $this->authorize('update', Router::class);

        return view('network.routers.edit', ['router' => $ip]);
    }

    public function update(Request $request, Router $ip)
    {
        $this->authorize('update', Router::class);

        Validator::make($request->all(), [
            'ip' => 'required|max:15|ip',
            'room' => 'required|integer',
            'mac_WAN' => ['nullable', 'regex:/^(([a-f0-9]{2}[-:]){5}([a-f0-9]{2}))$/i'],
            'mac_2G_LAN' => ['nullable', 'regex:/^(([a-f0-9]{2}[-:]){5}([a-f0-9]{2}))$/i'],
            'mac_5G' => ['nullable', 'regex:/^(([a-f0-9]{2}[-:]){5}([a-f0-9]{2}))$/i'],
            'comment' => 'max:255',
        ])->validate();

        $ip->update($request->all());

        return view('network.routers.view', ['router' => $ip]);
    }

    public function delete(Router $ip)
    {
        $this->authorize('delete', Router::class);

        $ip->delete();

        return redirect(route('routers'));
    }
}
