<?php

namespace App\Http\Controllers\Secretariat;

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
        $users = User::with('roles')->orderBy('name')->get();

        return view('secretariat.permissions.list', ['users' => $users]);
    }

    public function show($id)
    {
        $user = User::find($id);

        $this->authorize('viewPermissionFor', $user);

        return view('secretariat.permissions.show', ['user' => $user]);
    }

    public function edit(Request $request, $id, $role_id)
    {
        $user = User::find($id);

        $this->authorize('updatePermission', [$user, $role_id]);
        $roleName = Role::find($role_id)->name;
        $object_id = $request[$roleName] ?? null;

        $user_id = Role::canBeAttached($role_id, $object_id);
        if ($user_id < -1) {
            abort(500, 'The role cannot be assigned.');
        }
        if ($user_id > 0) {
            return back()->with('message', __('role.role_unavailable', ['user' => User::find($user_id)->name]));
        }
        //0 means ok:
        if ($object_id) {
            if ($roleName == Role::COLLEGIST && $user->isCollegist()) {
                //change resident/extern status
                $user->roles()->where('id', $role_id)->update(['object_id' => $object_id]);
            }
            if ($user->roles()->where('id', $role_id)->wherePivot('object_id', $object_id)->count() == 0) {
                $user->roles()->attach([
                    $role_id => ['object_id' => $object_id],
                ]);
            }
        } else {
            if ($user->roles()->where('id', $role_id)->count() == 0) {
                $user->roles()->attach($role_id);
            }
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
