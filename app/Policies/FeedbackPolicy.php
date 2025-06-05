<?php

namespace App\Policies;

use App\Enums\UserRoles;
use App\Models\Feedback;
use App\Models\User;

class FeedbackPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->role === UserRoles::ADMIN->value || $user->role === UserRoles::MODERATOR->value;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Feedback $model): bool
    {
        return $user->role === UserRoles::ADMIN->value || $user->role === UserRoles::MODERATOR->value;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Feedback $model): bool
    {
        return $user->role === UserRoles::ADMIN->value;
    }
}
