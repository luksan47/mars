<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class LocaleController extends Controller
{
    public function set(Request $request, $locale) {
        App::setLocale($locale);
        $request->session()->put('locale', $locale);
        return redirect()->back();
    }
}
