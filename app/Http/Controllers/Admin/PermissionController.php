<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:permission.handle');
    }

    public function index()
    {
        $users = User::all()->sortBy('name');

        return view('admin.permissions.list', ['users' => $users]);
    }

    public function show($id)
    {
        $user = User::find($id);

        $this->authorize('viewPermissionFor', $user);

        return view('admin.permissions.show', ['user' => $user]);
    }

    public function edit(Request $request, $id, $role_id)
    {
        $user = User::find($id);

        $this->authorize('updatePermission', [$user, $role_id]);

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

        $this->authorize('deletePermission', [$user, $role_id]);

        $role = Role::find($role_id);
        if ($role->canHaveObject()) {
            $user->roles()->where('id', $role_id)->wherePivot('object_id', $object_id)->detach($role_id);
        } else {
            $user->roles()->detach($role_id);
        }

        return back();
    }
}
