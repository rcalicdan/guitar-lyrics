<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Song;

class SongPolicy
{
    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Song $model): bool
    {
        return $user->isAdmin() || $user->isModerator() || $user->id === $model->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Song $model): bool
    {
        return $user->isAdmin() || $user->isModerator() || $user->id === $model->user_id;
    }
}
