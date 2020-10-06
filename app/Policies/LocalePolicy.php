<?php

namespace App\Policies;

use App\Models\LocalizationContribution;
use App\Models\Role;
use App\Models\User;
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
