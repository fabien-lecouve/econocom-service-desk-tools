<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['project_id', 'language_id', 'signature'])]
class ProjectLanguageSetting extends Model
{
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
