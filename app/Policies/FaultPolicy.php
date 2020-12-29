<?php

namespace App\Policies;

use App\Models\Fault;
use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class FaultPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can create fault.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasRole(Role::STAFF) || $user->hasRole(Role::COLLEGIST) || $user->hasRole(Role::TENANT);
    }

    /**
     * Determine whether the user can update the status of the fault.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function update(User $user)
    {
        return $user->hasRole(Role::STAFF);
    }
}
