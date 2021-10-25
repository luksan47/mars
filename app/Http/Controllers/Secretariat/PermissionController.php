<?php

namespace App\Http\Controllers\Secretariat;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
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

        if (! Role::canBeAttached($role_id, $object_id)) {
            $user = User::whereHas('roles', function (Builder $query) use ($role_id, $object_id) {
                $query->where('id', $role_id)->where('role_users.object_id', $object_id);
            })->first();
            if ($user) {
                return back()->with('message', __('role.role_unavailable', ['user' => $user->name]));
            } else {
                return back()->with('message', __('role.role_can_not_be_attached'));
            }
        }

        if ($object_id) {
            //if adding a collegist role to a collegist
            if ($roleName == Role::COLLEGIST && $user->isCollegist()) {
                //just change resident/extern status (object) - not attaching a new role.
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
