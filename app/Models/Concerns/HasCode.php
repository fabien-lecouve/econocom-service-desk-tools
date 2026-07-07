<?php

namespace App\Models\Concerns;

use Illuminate\Support\Str;

trait HasCode
{
    protected static function bootHasCode(): void
    {
        static::saving(function ($model) {
            if (! empty($model->label)) {
                $model->code = Str::slug($model->label);
            }
        });
    }
}
