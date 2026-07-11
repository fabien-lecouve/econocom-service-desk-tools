<?php

namespace App\Models\Concerns;

use Illuminate\Support\Str;

trait HasSlugCode
{
    protected static function bootHasSlugCode(): void
    {
        static::creating(function ($model) {
            $model->code = static::generateUniqueCode($model->label);
        });
    }

    protected static function generateUniqueCode(string $label): string
    {
        $base = Str::slug($label);
        $code = $base;
        $i = 2;

        while (static::where('code', $code)->exists()) {
            $code = "{$base}-{$i}";
            $i++;
        }

        return $code;
    }
}
