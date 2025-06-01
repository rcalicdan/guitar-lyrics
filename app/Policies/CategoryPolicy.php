<?php

namespace App\Policies;

use App\Models\User;
use App\Models\SongCategory;

class CategoryPolicy
{
    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->isAdmin() || $user->isModerator();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, SongCategory $model): bool
    {
        return $user->isAdmin() || $user->isModerator();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, SongCategory $model): bool
    {
        return $user->isAdmin() || $user->isModerator();
    }
}
