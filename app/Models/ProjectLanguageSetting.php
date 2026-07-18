<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable(['project_id', 'language_id', 'signature', 'internal_phone_override', 'external_phone_override'])]
class ProjectLanguageSetting extends Model
{
    use SoftDeletes;

    /**
     * Get the project that owns the language setting.
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Get the language that owns the language setting.
     */
    public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class);
    }
}
