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
        return $user->isCollegist();
    }

    public function viewAny(User $user)
    {
        return $user->isCollegist();
    }

    public function addPayment(User $user, Checkout $checkout)
    {
        if ($checkout->name === Checkout::STUDENTS_COUNCIL) {
            return $user->hasRoleWithObjectName(Role::STUDENT_COUNCIL, 'economic-leader');
        }
        if ($checkout->name === Checkout::ADMIN) {
            return $user->hasRole(Role::NETWORK_ADMIN);
        }

        return false;
    }

    public function addKKTNetreg(User $user)
    {
        return $user->hasRoleWithObjectNames(Role::STUDENT_COUNCIL, ['economic-member', 'economic-leader']);
    }

    public function administrate(User $user, Checkout $checkout)
    {
        if ($checkout->name === Checkout::STUDENTS_COUNCIL) {
            return $user->hasRoleWithObjectNames(Role::STUDENT_COUNCIL, ['economic-leader']);
        }
        if ($checkout->name === Checkout::ADMIN) {
            return $user->hasRole(Role::NETWORK_ADMIN);
        }

        return false;
    }

    public function handleAny(User $user)
    {
        $checkouts = Checkout::all();
        foreach ($checkouts as $checkout) {
            if ($this->addPayment($user, $checkout)) {
                return true;
            }
        }

        return false;
    }
}
