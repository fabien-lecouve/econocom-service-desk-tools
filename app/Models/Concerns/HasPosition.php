<?php

namespace App\Models\Concerns;

trait HasPosition
{
    public static function setPosition(string $column, ?int $parentId): int
    {
        return static::where($column, $parentId)
            ->max('position') + 1;
    }
}
