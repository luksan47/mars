<?php

namespace App\Http\Controllers\StudentsCouncil;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\EpistolaCollegii;
use Image;

use App\Models\EpistolaNews;

class EpistolaController extends Controller
{
    public function index(Request $request)
    {
        return view('student-council.communicational-committee.epistola', ['news' => EpistolaNews::all()->sortByDesc('valid_until')]);
    }

    public function send()
    {
        $this->authorize('send', EpistolaNews::class);
        return (new EpistolaCollegii())->toMail();

    }
}
