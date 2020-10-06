<?php

namespace App\Policies;

use App\User;
use App\Role;
use App\WifiConnection;
use Illuminate\Auth\Access\HandlesAuthorization;

class WifiConnectionPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasRole(Role::INTERNET_ADMIN);
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @param  \App\WifiConnection  $wifiConnection
     * @return mixed
     */
    public function view(User $user, WifiConnection $wifiConnection)
    {
        return $user->hasRole(Role::INTERNET_ADMIN)
            || $user->wifiConnections->contains($wifiConnection);
    }
}
