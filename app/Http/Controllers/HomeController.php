<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Log;

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
        Log::info('log');
        Cookie::queue('theme', $mode, config('app.colormode_cookie_lifespan'));
        return back()->with('theme', $mode);
    }
}
