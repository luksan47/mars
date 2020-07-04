<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class LocaleController extends Controller
{
    public function set(Request $request, $locale)
    {
        App::setLocale($locale);
        return redirect()->back()->cookie('locale', $locale, config('app.locale_cookie_lifespan'));
    }

    public function list()
    {
        $locale = [];
        $languages = array_diff(scandir(base_path('resources/lang/')), ['..', '.']);
        foreach ($languages as $language) {
            $files = array_diff(scandir(base_path('resources/lang/'.$language)), ['..', '.']);
            foreach ($files as $file_in) {
                if ($file_in != 'validation.php') {
                    $name = substr($file_in, 0, strlen($file_in) - 4);
                    $expressions = require base_path('resources/lang/'.$language.'/'.$file_in);
                    $locale[$language][$name] = $expressions;
                }
            }
        }
        return view('locale.app')->with('locale', $locale);
    }
}
