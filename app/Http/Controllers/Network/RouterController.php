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

        return view('network.routers.list')->with('routers', $routers);
    }

    public function view($ip)
    {
        $router = Router::findOrFail($ip);
        
        $this->authorize('view', $router);
        
        return view('network.routers.view')->with('router', $router);
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
            'ip' => 'max:15|ip',
            'room' => 'required',
            'mac_wan' => ['nullable', 'regex:/^(([a-f0-9]{2}[-:]){5}([a-f0-9]{2}))$/i'],
            'mac_2g_lan' => ['nullable', 'regex:/^(([a-f0-9]{2}[-:]){5}([a-f0-9]{2}))$/i'],
            'mac_5g' => ['nullable', 'regex:/^(([a-f0-9]{2}[-:]){5}([a-f0-9]{2}))$/i'],
            'comment' => 'max:255',
        ])->validate();

        $router = Router::create([
            'ip' => $request->ip,
            'room' => $request->room,
            'port' => $request->port,
            'type' => $request->type,
            'serial_number' => $request->serial_number,
            'mac_WAN' => $request->mac_wan,
            'mac_2G_LAN' => $request->mac_2g_lan,
            'mac_5G' => $request->mac_5g,
            'comment' => $request->comment,
            'date_of_acquisition' => $request->date_of_acquisition,
            'date_of_deployment' => $request->date_of_deployment,
            'failed_for' => 0,
        ]);

        return redirect('/routers/' . $router->ip)->with('router', $router);
    }

    public function edit($ip)
    {
        $this->authorize('update', Router::class);

        $router = Router::findOrFail($ip);

        return view('network.routers.edit')->with('router', $router);
    }

    public function update(Request $request, $ip)
    {
        $this->authorize('update', Router::class);

        Validator::make($request->all(), [
            'ip' => 'required|max:15|ip',
            'room' => 'required',
            'mac_wan' => ['nullable', 'regex:/^(([a-f0-9]{2}[-:]){5}([a-f0-9]{2}))$/i'],
            'mac_2g_lan' => ['nullable', 'regex:/^(([a-f0-9]{2}[-:]){5}([a-f0-9]{2}))$/i'],
            'mac_5g' => ['nullable', 'regex:/^(([a-f0-9]{2}[-:]){5}([a-f0-9]{2}))$/i'],
            'comment' => 'max:255',
        ])->validate();

        $router = Router::findOrFail($ip);
        $router->update([
            'ip' => $request->ip,
            'room' => $request->room,
            'port' => $request->port,
            'type' => $request->type,
            'serial_number' => $request->serial_number,
            'mac_WAN' => $request->mac_wan,
            'mac_2G_LAN' => $request->mac_2g_lan,
            'mac_5G' => $request->mac_5g,
            'comment' => $request->comment,
            'date_of_acquisition' => $request->date_of_acquisition,
            'date_of_deployment' => $request->date_of_deployment
        ]);

        return redirect('/routers/' . $router->ip)->with('router', $router);
    }

    public function delete(Request $request, $ip)
    {
        $this->authorize('delete', Router::class);

        $router = Router::findOrFail($ip);
        $router->delete();

        $routers = Router::all()->sortBy('room');

        return redirect('/routers')->with('routers', $routers);
    }
}
