<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function colorMode($mode)
    {
        return response('ok')->cookie('theme', $mode, config('app.colormode_cookie_lifespan'));
    }
}
