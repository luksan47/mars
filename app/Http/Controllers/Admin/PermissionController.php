<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\User;
use App\Role;

class PermissionController extends Controller
{
    public function __construct()
    {
        // TODO change
        $this->middleware('can:registration.handle');
    }

    public function index()
    {
        $users = User::all();
        return view('admin.permissions.list', ['users' => $users]);
    }

    public function show($id)
    {
        $user = User::find($id);
        return view('admin.permissions.show', ['user' => $user]);
    }

    public function edit(Request $request, $id, $role_id)
    {
        $user = User::find($id);
        $role = Role::find($role_id);
        if ($role->canHaveObject()) {
            $object_id = $request[$role->name];
            $user->roles()->attach([
                $role_id => ['object_id' => $object_id],
            ]);
        } else {
            $user->roles()->attach($role_id);
        }
        return back();
    }

    public function remove(Request $request, $id, $role_id)
    {
        $user = User::find($id);
        $role = Role::find($role_id);
        if ($role->canHaveObject()) {

        } else {
            $user->roles()->detach($role_id);
        }
        return back();
    }
}
