<?php

namespace App\Policies;

use App\Models\Message;
use App\Models\Project;
use App\Models\Role;
use App\Models\User;
use App\Policies\Concerns\HasProjectAccess;

class MessagePolicy
{
    use HasProjectAccess;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user, Project $project): bool
    {
        return $user->is_admin
            || $this->isProjectMember($user, $project->id);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Message $message): bool
    {
        return $user->is_admin
            || $this->isProjectMember($user, $message->project_id);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user, Project $project): bool
    {
        return $user->is_admin
            || $this->hasProjectRole($user, $project->id, [
                Role::TECHNICIAN,
                Role::TECHNICIAN_REFERENT,
                Role::TECHNICAL_COORDINATOR,
            ]);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Message $message): bool
    {
        return $user->is_admin
            || $this->hasProjectRole($user, $message->project_id, [
                Role::TECHNICIAN,
                Role::TECHNICIAN_REFERENT,
                Role::TECHNICAL_COORDINATOR,
            ]);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Message $message): bool
    {
        return $user->is_admin
            || $this->hasProjectRole($user, $message->project_id, [
                Role::TECHNICIAN_REFERENT,
                Role::TECHNICAL_COORDINATOR,
            ]);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Message $message): bool
    {
        return $user->is_admin
            || $this->hasProjectRole($user, $message->project_id, [
                Role::TECHNICIAN_REFERENT,
                Role::TECHNICAL_COORDINATOR,
            ]);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Message $message): bool
    {
        return $user->is_admin;
    }
}
