<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

#[Fillable(['code', 'label', 'phone'])]
class Project extends Model
{
    /**
     * Get the memberships for the project.
     */
    public function memberships(): HasMany
    {
        return $this->hasMany(Membership::class);
    }

    /**
     * Get the categories for the project.
    */
    public function categories(): HasMany
    {
        return $this->hasMany(Category::class);
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }

    /**
     * Get the project language settings for the project.
     */
    public function projectLanguageSettings(): HasMany
    {
        return $this->hasMany(ProjectLanguageSetting::class);
    }
}
