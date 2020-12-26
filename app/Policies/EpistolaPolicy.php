<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Role;
use Illuminate\Auth\Access\HandlesAuthorization;

class EpistolaPolicy
{
    use HandlesAuthorization;

    public function create(User $user)
    {
        return $user->hasRoleBase(Role::COLLEGIST);
        //return $user->hasRoleWithObjectNames(Role::STUDENT_COUNCIL, ['communication-leader', 'communication-member']);
    }

    public function edit(User $user)
    {
        return $user->hasRoleWithObjectNames(Role::STUDENT_COUNCIL, ['communication-leader', 'communication-member']);
    }

    public function send(User $user)
    {
        return $user->hasRoleWithObjectName(Role::STUDENT_COUNCIL, 'communication-leader');
    }

}
