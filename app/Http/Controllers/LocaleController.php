<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class LocaleController extends Controller
{
    public function set(Request $request, $locale) {
        App::setLocale($locale);
        return redirect()->back()->cookie('locale', $locale, config('locale_cookie_lifespan'));
    }
}
