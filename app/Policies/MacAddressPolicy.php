<?php

namespace App\Policies;

use App\Models\MacAddress;
use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class MacAddressPolicy
{
    use HandlesAuthorization;

    public function before(User $user)
    {
        if ($user->hasRole(Role::NETWORK_ADMIN)) {
            return true;
        }
        if (! $user->hasRole(Role::INTERNET_USER)) {
            return false;
        }
    }

    /**
     * Determine whether the user can view any mac addresses (in general).
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return false;
    }

    /**
     * Determine whether the user can view the mac address.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\MacAddress  $macAddress
     * @return mixed
     */
    public function view(User $user, MacAddress $macAddress)
    {
        return $user->id === $macAddress->user_id;
    }

    /**
     * Determine whether the user can create mac addresses.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the mac address.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\MacAddress  $macAddress
     * @return mixed
     */
    public function update(User $user, MacAddress $macAddress)
    {
        return $user->id === $macAddress->user_id;
    }

    /**
     * Determine whether the user can delete the mac address.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\MacAddress  $macAddress
     * @return mixed
     */
    public function delete(User $user, MacAddress $macAddress)
    {
        return $user->id === $macAddress->user_id;
    }

    /**
     * Determine whether the user can accept the mac address request.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\MacAddress  $macAddress
     * @return mixed
     */
    public function accept(User $user)
    {
        return false;
    }
}
