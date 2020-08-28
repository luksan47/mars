<?php

namespace App\Policies;

use App\User;
use App\Role;
use Illuminate\Auth\Access\HandlesAuthorization;

class PermissionPolicy
{
    use HandlesAuthorization;

    public function before(User $user)
    {
        if (!$user->hasRole(Role::PERMISSION_HANDLER)) {
            return false;
        }
    }

    public function viewAny(User $user)
    {
        return true;
    }

    public function view(User $user, User $target)
    {
        return $user->id !== $target->id;
    }

    public function create(User $user)
    {
        return $user->id !== $target->id;
    }

    public function update(User $user, User $target)
    {
        return $user->id !== $target->id;
    }

    public function delete(User $user, User $target)
    {
        return $user->id !== $target->id;
    }
}
