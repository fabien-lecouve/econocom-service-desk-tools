<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable([
    'project_id',
    'language_id',
    'signature',
    'internal_phone_override',
    'external_phone_override'
    ])
]
class ProjectLanguageSetting extends Model
{
    use SoftDeletes;

    // BELONGS TO
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class);
    }
}
