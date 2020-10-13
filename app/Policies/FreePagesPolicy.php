<?php

namespace App\Policies;

use App\Models\FreePages;
use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class FreePagesPolicy
{
    use HandlesAuthorization;

    public function before(User $user)
    {
        if ($user->hasRole(Role::PRINT_ADMIN)) {
            return true;
        }
        if (! $user->hasRole(Role::PRINTER)) {
            return false;
        }
    }

    public function viewAny(User $user)
    {
        return false;
    }

    public function viewSelf(User $user)
    {
        return true;
    }

    public function view(User $user, FreePages $freePages)
    {
        return $freePages->user_id == $user->id;
    }

    public function create(User $user)
    {
        return false;
    }

    public function update(User $user, FreePages $freePages)
    {
        return $freePages->user_id == $user->id;
    }
}
