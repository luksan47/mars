<?php

namespace App\Policies;

use App\Models\Role;
use App\Models\User;
use App\Models\WifiConnection;
use Illuminate\Auth\Access\HandlesAuthorization;

class WifiConnectionPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasRole(Role::INTERNET_ADMIN);
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\WifiConnection  $wifiConnection
     * @return mixed
     */
    public function view(User $user, WifiConnection $wifiConnection)
    {
        return $user->hasRole(Role::INTERNET_ADMIN)
            || $user->wifiConnections->contains($wifiConnection);
    }
}
