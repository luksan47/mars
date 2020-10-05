<?php

namespace App\Policies;

use App\Checkout;
use App\Role;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CheckoutPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the checkout.
     */
    public function view(User $user, Checkout $checkout)
    {
        return $user->hasRoleBase(Role::COLLEGIST);
    }

    public function viewAny(User $user)
    {
        return $user->hasRoleBase(Role::COLLEGIST);
    }

    public function addPayment(User $user, Checkout $checkout)
    {
        if ($checkout->name === Checkout::STUDENTS_COUNCIL) {
            return $user->hasRoleWithObjectNames(Role::STUDENT_COUNCIL, ['economic-member', 'economic-leader']);
        }
        if ($checkout->name === Checkout::ADMIN) {
            return $user->hasRoleWithObjectNames(Role::STUDENT_COUNCIL, ['economic-member', 'economic-leader'])
                || $user->hasRole(Role::INTERNET_ADMIN);
        }

        return false;
    }

    public function administrate(User $user, Checkout $checkout)
    {
        if ($checkout->name === Checkout::STUDENTS_COUNCIL) {
            return $user->hasRoleWithObjectNames(Role::STUDENT_COUNCIL, ['economic-leader']);
        }
        if ($checkout->name === Checkout::ADMIN) {
            return $user->hasRole(Role::INTERNET_ADMIN);
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
