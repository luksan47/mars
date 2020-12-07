<?php

namespace App\Http\Controllers\Secretariat;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;

class SemesterController extends Controller
{
    public function statuses()
    {
        $this->authorize('viewAny', User::class);

        $collegists = User::role(Role::COLLEGIST)
            ->with(['educationalInformation', 'allSemesters', 'roles'])
            ->orderBy('name')->get();

        return view('secretariat.statuses.list', ['collegists' => $collegists]);
    }
}
