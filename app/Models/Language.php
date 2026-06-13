<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

#[Fillable(['code', 'label'])]
class Language extends Model
{
    /**
     * Get the project language settings for the language.
     */
    public function projectLanguageSettings(): HasMany
    {
        return $this->hasMany(ProjectLanguageSetting::class);
    }

    /**
     * Get the message translations for the language.
     */
    public function messageTranslations(): HasMany
    {
        return $this->hasMany(MessageTranslation::class);
    }

    /**
     * Get the language setting associated with the language.
     */
    public function setting(): HasOne
    {
        return $this->hasOne(LanguageSetting::class);
    }
}
