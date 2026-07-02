<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['project_id', 'parent_id', 'font_color_id', 'background_color_id', 'border_top_color_id', 'code', 'label', 'position'])]
class Category extends Model
{
    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'position' => 'integer',
        ];
    }


    /**
     * Get the project that owns the category.
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Get the parent category.
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }


    /**
     * Get the child categories.
     */
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id')
            ->orderBy('position')
            ->with('children');
    }

    /**
     * Get the messages for the category.
     */
    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }


    /**
     * Get the font color that owns the category.
     */
    public function fontColor(): BelongsTo
    {
        return $this->belongsTo(Color::class, 'font_color_id');
    }

    /**
     * Get the background color that owns the category.
     */
    public function backgroundColor(): BelongsTo
    {
        return $this->belongsTo(Color::class, 'background_color_id');
    }

    /**
     * Get the border top color that owns the category.
     */
    public function borderTopColor(): BelongsTo
    {
        return $this->belongsTo(Color::class, 'border_top_color_id');
    }
}
