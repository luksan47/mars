<?php

namespace App\Policies;

use App\Models\Checkout;
use App\Models\PaymentType;
use App\Models\Role;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TransactionPolicy
{
    use HandlesAuthorization;

    public function delete(User $user, Transaction $transaction)
    {
        // No transaction that has been moved to checkout can be deleted.
        if ($transaction->moved_to_checkout) {
            return false;
        }

        //print transaction should not be deleted as deleting won't change the user's print balance
        if ($transaction->type->name == PaymentType::PRINT) {
            return false;
        }

        if ($transaction->receiver->id != $user->id) {
            //TODO return true for checkout handlers (we do not use that now)
            return false;
        }

        if ($transaction->checkout->name == Checkout::admin()->name) {
            return $user->hasRole(Role::NETWORK_ADMIN);
        }

        if ($transaction->checkout->name == Checkout::studentsCouncil()->name) {
            return $user->hasRoleWithObjectNames(Role::STUDENT_COUNCIL, ['economic-member', 'economic-leader']);
        }

        return false;
    }
}
