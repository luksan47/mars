<?php

namespace App\Policies;

use App\InternetAccess;
use App\User;
use App\Role;
use Illuminate\Auth\Access\HandlesAuthorization;

class InternetAccessPolicy
{
    use HandlesAuthorization;

    public function before(User $user, $ability)
    {
        if ($user->hasRole(Role::INTERNET_ADMIN)) {
            return true;
        }
        if (!$user->hasRole(Role::INTERNET_USER)){
            return false;
        }
    }

    /**
     * Determine whether the user can view any internet accesses.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return false;
    }

    /**
     * Determine whether the user can view the internet access.
     *
     * @param  \App\User  $user
     * @param  \App\InternetAccess  $internetAccess
     * @return mixed
     */
    public function view(User $user, InternetAccess $internetAccess)
    {
        return $user->id === $internetAccess->user_id;
    }

    /**
     * Determine whether the user can create internet accesses.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return false;
    }

    /**
     * Determine whether the user can update the internet access.
     *
     * @param  \App\User  $user
     * @param  \App\InternetAccess  $internetAccess
     * @return mixed
     */
    public function update(User $user, InternetAccess $internetAccess)
    {
        return false;
    }

    /**
     * Determine whether the user can delete the internet access.
     *
     * @param  \App\User  $user
     * @param  \App\InternetAccess  $internetAccess
     * @return mixed
     */
    public function delete(User $user, InternetAccess $internetAccess)
    {
        return false;
    }
}
