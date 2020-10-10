<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;

class SemesterController extends Controller
{
    public function statuses()
    {
        $this->authorize('viewAny', User::class);

        $collegists = User::all()->filter(function ($value, $key) {
            return $value->hasRoleBase(Role::COLLEGIST);
        })->sortBy('name');

        return view('admin.statuses.list', ['collegists' => $collegists]);
    }
}
