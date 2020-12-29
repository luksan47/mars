<?php

namespace App\Policies;

use App\Models\PrintJob;
use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PrintJobPolicy
{
    use HandlesAuthorization;

    public function before(User $user)
    {
        if ($user->hasRole(Role::PRINT_ADMIN)) {
            return true;
        }
        if (! $user->hasRole(Role::PRINTER)) {
            return false;
        }
    }

    /**
     * Determine whether the user can view any print jobs.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return false;
    }

    /**
     * Determine whether the user can view his/her print jobs.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\PrintJob  $printJob
     * @return mixed
     */
    public function viewSelf(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the print job.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\PrintJob  $printJob
     * @return mixed
     */
    public function update(User $user, PrintJob $printJob)
    {
        return $printJob->user_id === $user->id;
    }
}
