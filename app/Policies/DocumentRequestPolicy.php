<?php

namespace App\Policies;

use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DocumentRequestPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $user->hasAnyRole([Role::NETWORK_ADMIN, Role::SECRETARY, Role::PERMISSION_HANDLER]);
    }
}
