<?php

namespace App\Policies;

use App\Enums\UserRoles;
use App\Models\Comments;
use App\Models\User;

class CommentPolicy
{
    /**
     * Determine if the user can update the comment
     */
    public function update(User $user, Comments $comment): bool
    {
        if ($user->id === $comment->user_id) {
            return true;
        }

        return in_array($user->role, [UserRoles::ADMIN->value, UserRoles::MODERATOR->value]);
    }

    /**
     * Determine if the user can delete the comment
     */
    public function delete(User $user, Comments $comment): bool
    {
        if ($user->id === $comment->user_id) {
            return true;
        }

        return in_array($user->role, [UserRoles::ADMIN->value, UserRoles::MODERATOR->value]);
    }
}
