<?php

namespace App\Http\Controllers\StudentsCouncil;

use App\Http\Controllers\Controller;
use App\Models\EpistolaNews;
use Illuminate\Http\Request;

class EpistolaController extends Controller
{
    public function index(Request $request)
    {
        return view('student-council.communicational-committee.epistola', ['news' => EpistolaNews::all()->sortByDesc('valid_until')]);
    }
}
