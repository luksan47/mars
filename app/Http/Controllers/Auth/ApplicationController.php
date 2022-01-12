<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Faculty;
use App\Models\Workshop;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{

    public function showApplicationForm(Request $request)
    {
        return view('auth.application', [
            'workshops' => Workshop::all(),
            'faculties' => Faculty::all(),
            'deadline' => self::getApplicationDeadline(),
            'deadline_extended' => self::isDeadlineExtended(),
            'countries' => require base_path('countries.php'),
            'user' => $request->user()
        ]);
    }

    public static function getApplicationDeadline() : Carbon
    {
        return Carbon::parse(config('app.application_deadline'));
    }

    public static function isDeadlineExtended() : bool
    {
        return config('app.application_extended');
    }
};
