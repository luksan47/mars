<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cookie;

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
        Cookie::queue('colormode', $mode, config('app.colormode_cookie_lifespan'));
        return back();
    }
}
