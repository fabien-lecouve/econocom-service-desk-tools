<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

#[Fillable([
    'code',
    'label'
    ])
]
class Language extends Model
{
    // HAS ONE
    public function setting(): HasOne
    {
        return $this->hasOne(LanguageSetting::class);
    }


    // HAS MANY
    public function projectLanguageSettings(): HasMany
    {
        return $this->hasMany(ProjectLanguageSetting::class);
    }

    public function messageTranslations(): HasMany
    {
        return $this->hasMany(MessageTranslation::class);
    }
}
