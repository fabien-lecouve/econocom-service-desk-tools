<?php

namespace App\Policies\Concerns;

use App\Models\User;

trait HasProjectAccess
{
    private function isProjectMember(User $user, int $projectId): bool
    {
        return $user->memberships()
            ->where('project_id', $projectId)
            ->exists();
    }

    private function hasProjectRole(User $user, int $projectId, array $roles): bool
    {
        return $user->memberships()
            ->where('project_id', $projectId)
            ->whereHas(
                'role',
                fn ($query) => $query->whereIn('code', $roles)
            )
            ->exists();
    }
}
