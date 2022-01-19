<?php

namespace App\Policies;

use App\Models\Role;
use App\Models\User;
use App\Models\Router;
use Illuminate\Auth\Access\HandlesAuthorization;

class RouterPolicy
{
    use HandlesAuthorization;

    public function before(User $user, $ability)
    {
        if ($user->hasRole(Role::NETWORK_ADMIN)) {
            return true;
        }
    }

    /**
     * Determine whether the user can view any routers.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->isCollegist();
    }

    /**
     * Determine whether the user can view the router.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Router  $router
     * @return mixed
     */
    public function view(User $user, Router $router)
    {
        return $user->isCollegist();
    }

    /**
     * Determine whether the user can create routers.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasRole('internet_admin');
    }

    /**
     * Determine whether the user can update the router.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Router  $router
     * @return mixed
     */
    public function update(User $user, Router $router)
    {
        return $user->hasRole('internet_admin');
    }

    /**
     * Determine whether the user can delete the router.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Router  $router
     * @return mixed
     */
    public function delete(User $user, Router $router)
    {
        return $user->hasRole('internet_admin');
    }
}
