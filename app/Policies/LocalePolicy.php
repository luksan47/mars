<?php

namespace App\Policies;

use App\LocalizationContribution;
use App\Role;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class LocalePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $user->hasRoleBase(Role::LOCALE_ADMIN);
    }

    public function approve(User $user, LocalizationContribution $contribution)
    {
        return $user->hasRoleWithObjectName(Role::LOCALE_ADMIN, $contribution->language);
    }
}
