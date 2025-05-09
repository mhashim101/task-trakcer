<?php

namespace App\Policies;

use App\Models\TaskAttachment;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TaskAttachmentPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, TaskAttachment $taskAttachment): bool
    {
        return in_array($user->role_id, [1, 2]) || $user->id === $taskAttachment->user_id;
    }


    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, TaskAttachment $taskAttachment): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, TaskAttachment $attachment)
    {
        return $user->id === $attachment->user_id || in_array($user->role_id, [1, 2]);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, TaskAttachment $taskAttachment): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, TaskAttachment $taskAttachment): bool
    {
        return false;
    }
}
