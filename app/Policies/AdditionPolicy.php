<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\Addition;
use App\Models\User;

class AdditionPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->checkPermissionTo('view-any Addition');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Addition $addition): bool
    {
        return $user->checkPermissionTo('view Addition');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->checkPermissionTo('create Addition');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Addition $addition): bool
    {
        return $user->checkPermissionTo('update Addition');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Addition $addition): bool
    {
        return $user->checkPermissionTo('delete Addition');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Addition $addition): bool
    {
        return $user->checkPermissionTo('restore Addition');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Addition $addition): bool
    {
        return $user->checkPermissionTo('force-delete Addition');
    }
}
