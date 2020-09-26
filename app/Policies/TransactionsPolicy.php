<?php

namespace App\Policies;

use App\Role;
use App\User;
use App\Transaction;
use Illuminate\Auth\Access\HandlesAuthorization;

class TransactionsPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the Economic Committee's statistics.
     */
    public function viewEconomicStat(User $user)
    {
        if ($user->hasRole(Role::Collegist)) {
            return true;
        }
    }

    /**
     * Determine whether the user can create Economic Committee transactions.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function createEconomicTransaction(User $user)
    {
        if ($user->hasRole(Role::STUDENT_COUNCIL)) {
            return true;
        }
    }
}
