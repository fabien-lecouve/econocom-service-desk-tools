<?php

namespace App\Models;

use App\Models\Concerns\HasSlugCode;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable(['code', 'label', 'phone', 'email'])]
class Project extends Model
{
    use HasSlugCode, SoftDeletes;
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
