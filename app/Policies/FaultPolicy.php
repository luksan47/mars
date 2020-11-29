<?php

namespace App\Policies;

use App\Models\Fault;
use App\Models\User;
use App\Models\Role;
use Illuminate\Auth\Access\HandlesAuthorization;

class FaultPolicy
{
    use HandlesAuthorization;

    // /**
    // * Determine whether the user can view any fault.
    // *
    // * @param  \App\Models\User  $user
    // * @return mixed
    // */
    //public function viewAny(User $user)
    //{
    //    return true;
    //}

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
     * @param  \App\Models\Fault  $fault
     * @return mixed
     */
    public function update(User $user, Fault $fault)
    {
        return $user->hasRole(Role::STAFF); // || getState($fault) === Fault::UNSEEN;
    }
}
