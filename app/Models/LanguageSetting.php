<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['language_id', 'salutation', 'closing'])]
class LanguageSetting extends Model
{
    /**
     * Get the language that owns these settings.
     */
    public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class);
    }
}
