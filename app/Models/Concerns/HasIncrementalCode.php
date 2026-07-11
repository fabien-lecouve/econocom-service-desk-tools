<?php

namespace App\Models\Concerns;

use App\Models\Project;
use Illuminate\Support\Str;

trait HasIncrementalCode
{
    protected static function generateIncrementalCode(Project $project, string $suffix): string
    {
        $prefix = "{$project->code}-{$suffix}-";

        $lastCode = static::withTrashed()
            ->where('project_id', $project->id)
            ->where('code', 'like', "{$prefix}%")
            ->orderByDesc('code')
            ->value('code');

        $lastNumber = $lastCode
            ? (int) Str::afterLast($lastCode, '-')
            : 0;

        $nextNumber = str_pad(
            (string) ($lastNumber + 1),
            3,
            '0',
            STR_PAD_LEFT
        );

        return "{$prefix}{$nextNumber}";
    }
}
