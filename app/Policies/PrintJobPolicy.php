<?php

namespace App\Policies;

use App\PrintJob;
use App\Role;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PrintJobPolicy
{
    use HandlesAuthorization;

    public function before(User $user)
    {
        if ($user->hasRole(Role::PRINT_ADMIN)) {
            return true;
        }
        if (!$user->hasRole(Role::PRINTER)){
            return false;
        }
    }

    /**
     * Determine whether the user can view any print jobs.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return false;
    }

    /**
     * Determine whether the user can view the print job.
     *
     * @param  \App\User  $user
     * @param  \App\PrintJob  $printJob
     * @return mixed
     */
    public function view(User $user, PrintJob $printJob)
    {
        return $printJob->user_id == $user->id;
    }

    /**
     * Determine whether the user can create print jobs.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the print job.
     *
     * @param  \App\User  $user
     * @param  \App\PrintJob  $printJob
     * @return mixed
     */
    public function update(User $user, PrintJob $printJob)
    {
        return $printJob->user_id == $user->id;
    }

    /**
     * Determine whether the user can delete the print job.
     *
     * @param  \App\User  $user
     * @param  \App\PrintJob  $printJob
     * @return mixed
     */
    public function delete(User $user, PrintJob $printJob)
    {
        return false;
    }
}
