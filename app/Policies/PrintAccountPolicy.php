<?php

namespace App\Policies;

use App\Models\PrintAccount;
use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PrintAccountPolicy
{
    use HandlesAuthorization;

    public function before(User $user, $ability)
    {
        if ($user->hasRole(Role::PRINT_ADMIN)) {
            return true;
        }
        if (! $user->hasRole(Role::PRINTER)) {
            return false;
        }
    }

    /**
     * True if the user can use his/her print account.
     */
    public function use(User $user)
    {
        return true;
    }

    public function handleAny(User $user)
    {
        return false;
    }

    public function view(User $user, PrintAccount $printAccount)
    {
        return $printAccount !== null && $user->id === $printAccount->user_id;
    }

    public function modify(User $user)
    {
        return false;
    }
}
