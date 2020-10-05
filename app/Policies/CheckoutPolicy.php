<?php

namespace App\Policies;

use App\Models\Checkout;
use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CheckoutPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the checkout.
     */
    public function view(User $user, Checkout $checkout)
    {
        return $user->hasRole(Role::COLLEGIST);
    }

    /**
     * Determine whether the user can create and handle transactions.
     */
    public function handle(User $user, Checkout $checkout)
    {
        return $user->hasRole(Role::STUDENT_COUNCIL);
    }

    public function handleAny(User $user)
    {
        return $user->hasRole(Role::STUDENT_COUNCIL);
    }
}
