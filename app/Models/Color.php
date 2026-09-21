<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['code', 'label', 'hex', 'position'])]
class Color extends Model
{
    public function categoriesAsFontColor(): HasMany
    {
        return $this->hasMany(Category::class, 'font_color_id');
    }
    public function categoriesAsBackgroundColor(): HasMany
    {
        return $this->hasMany(Category::class, 'background_color_id');
    }
    public function categoriesAsBorderTopColor(): HasMany
    {
        return $this->hasMany(Category::class, 'border_top_color_id');
    }


    public function messagesAsFontColor(): HasMany
    {
        return $this->hasMany(Message::class, 'font_color_id');
    }
    public function messagesAsBackgroundColor(): HasMany
    {
        return $this->hasMany(Message::class, 'background_color_id');
    }
    public function messagesAsBorderTopColor(): HasMany
    {
        return $this->hasMany(Message::class, 'border_top_color_id');
    }


    public function projectCategoryFontColorSettings(): HasMany
    {
        return $this->hasMany(ProjectCategoryColorSetting::class, 'font_color_id');
    }
    public function projectCategoryBackgroundColorSettings(): HasMany
    {
        return $this->hasMany(ProjectCategoryColorSetting::class, 'background_color_id');
    }
    public function projectCategoryBorderTopColorSettings(): HasMany
    {
        return $this->hasMany(ProjectCategoryColorSetting::class, 'border_top_color_id');
    }


    public function projectMessageTypeFontColorSettings(): HasMany
    {
        return $this->hasMany(ProjectMessageTypeColorSetting::class, 'font_color_id');
    }
    public function projectMessageTypeBackgroundColorSettings(): HasMany
    {
        return $this->hasMany(ProjectMessageTypeColorSetting::class, 'background_color_id');
    }
    public function projectMessageTypeBorderTopColorSettings(): HasMany
    {
        return $this->hasMany(ProjectMessageTypeColorSetting::class, 'border_top_color_id');
    }
}
