<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Role;
use App\User;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:permission.handle');
    }

    public function index()
    {
        $this->authorize('viewAny', User::class);

        $users = User::all();

        return view('admin.permissions.list', ['users' => $users]);
    }

    public function show($id)
    {
        $user = User::find($id);

        $this->authorize('view', $user);

        return view('admin.permissions.show', ['user' => $user]);
    }

    public function edit(Request $request, $id, $role_id)
    {
        $user = User::find($id);

        $this->authorize('update', $user);

        $role = Role::find($role_id);
        if ($role->canHaveObject()) {
            $object_id = $request[$role->name];
            if ($user->roles()->where('id', $role_id)->wherePivot('object_id', $object_id)->count() == 0) {
                $user->roles()->attach([
                    $role_id => ['object_id' => $object_id],
                ]);
            }
        } else {
            $user->roles()->attach($role_id);
        }

        return back();
    }

    public function remove(Request $request, $id, $role_id, $object_id = null)
    {
        $user = User::find($id);

        $this->authorize('delete', $user);

        $role = Role::find($role_id);
        if ($role->canHaveObject()) {
            $user->roles()->where('id', $role_id)->wherePivot('object_id', $object_id)->detach($role_id);
        } else {
            $user->roles()->detach($role_id);
        }

        return back();
    }
}
