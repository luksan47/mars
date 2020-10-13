<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

use Illuminate\Support\Facades\Storage;

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

    public function welcome()
    {
        if (Auth::user()) {
            return redirect('home');
        }

        return view('welcome');
    }

    public function verification()
    {
        return view('auth.verification');
    }

    public function privacyPolicy()
    {
        return Storage::response('public/adatvedelmi_tajekoztato.pdf');
    }

    public function setLocale($locale)
    {
        App::setLocale($locale);
        return redirect()->back()->cookie('locale', $locale, config('app.locale_cookie_lifespan'));
    }

    /**
     * E-mails need to access the logo.
     */
    public function getPicture($filename){
        $path = public_path() . '//img//' . $filename;

        if(!File::exists($path)) {
            return response()->json(['message' => 'Image not found'], 404);
        }

        $file = File::get($path);
        $type = File::mimeType($path);

        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);

        return $response;
    }
}
