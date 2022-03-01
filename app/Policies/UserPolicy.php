<?php

namespace App\Policies;

use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $user->hasAnyRole([Role::NETWORK_ADMIN, Role::SECRETARY, Role::PERMISSION_HANDLER]);
    }

    public function view(User $user, User $target)
    {
        return $user->hasAnyRole([Role::NETWORK_ADMIN, Role::SECRETARY, Role::PERMISSION_HANDLER]) || $user->id == $target->id;
    }

    public function viewPersonalInformation(User $user, User $target)
    {
        // TODO: later internet admins should be removed
        return $user->hasRole(Role::NETWORK_ADMIN)
            || ($target->hasRole(Role::COLLEGIST) && $user->hasRole(Role::SECRETARY))
            || $user->id == $target->id
            || ($target->hasRole(Role::TENANT) && $user->hasRole(Role::STAFF));
    }

    public function viewEducationalInformation(User $user, User $target)
    {
        // TODO: later internet admins should be removed
        return $user->hasAnyRole([Role::NETWORK_ADMIN, Role::SECRETARY]) || $user->id == $target->id;
    }

    /** Permission related policies */
    public function viewPermissionFor(User $user, User $target)
    {
        return $user->hasRole(Role::PERMISSION_HANDLER) && $user->id !== $target->id;
    }

    public function updatePermission(User $user, User $target, int $role_id)
    {
        $role = Role::find($role_id);

        return $user->hasRole(Role::PERMISSION_HANDLER) && $user->id !== $target->id && $role->name;// != Role::PERMISSION_HANDLER;
    }

    public function deletePermission(User $user, User $target, int $role_id)
    {
        $role = Role::find($role_id);

        return $user->hasRole(Role::PERMISSION_HANDLER) && $user->id !== $target->id && $role->name;// != Role::PERMISSION_HANDLER;
    }
}
