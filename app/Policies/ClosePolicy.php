<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\Close;
use App\Models\User;

class ClosePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->checkPermissionTo('view-any Close');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Close $close): bool
    {
        return $user->checkPermissionTo('view Close');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->checkPermissionTo('create Close');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Close $close): bool
    {
        return $user->checkPermissionTo('update Close');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Close $close): bool
    {
        return $user->checkPermissionTo('delete Close');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Close $close): bool
    {
        return $user->checkPermissionTo('restore Close');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Close $close): bool
    {
        return $user->checkPermissionTo('force-delete Close');
    }
}
