<?php

namespace App\Http\Controllers\Secretariat;

use App\Http\Controllers\Controller;
use App\Models\User;

class SemesterController extends Controller
{
    public function statuses()
    {
        $this->authorize('viewAny', User::class);

        $collegists = User::collegists()->sortBy('name');

        return view('secretariat.statuses.list', ['collegists' => $collegists]);
    }
}
