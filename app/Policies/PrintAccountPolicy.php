<?php

namespace App\Policies;

use App\PrintAccount;
use App\User;
use App\Role;
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

    public function view(User $user, PrintAccount $printAccount)
    {
        return $user->id == $printAccount->user_id;
    }
}
