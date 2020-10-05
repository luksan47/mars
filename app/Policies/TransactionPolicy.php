<?php

namespace App\Policies;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TransactionPolicy
{
    use HandlesAuthorization;

    public function delete(User $user, Transaction $transaction)
    {
        return $user->hasRole(Role::STUDENT_COUNCIL);
    }
}
