<?php

namespace App\Models\Concerns;

use App\Models\Project;

trait HasPosition
{
    public static function setPosition(Project $project, string $column, ?int $parentId): int
    {
        return static::where('project_id', $project->id)
            ->where($column, $parentId)
            ->max('position') + 1;
    }
}
