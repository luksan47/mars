<?php

namespace App\Policies;

use App\LocalizationContribution;
use App\Role;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class LocalePolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function viewAny(User $user)
    {
        return $user->hasRoleBase(Role::LOCALE_ADMIN);
    }

    public function approve(User $user, LocalizationContribution $contribution)
    {
        $objectId = Role::getObjectIdByName(Role::LOCALE_ADMIN, $contribution->language);

        return $user->hasRole(Role::LOCALE_ADMIN, $objectId);
    }
}
