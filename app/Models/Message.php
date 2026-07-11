<?php

namespace App\Models;

use App\Models\Concerns\HasIncrementalCode;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable(['project_id', 'category_id', 'message_type_id', 'font_color_id', 'background_color_id', 'border_top_color_id', 'code', 'label', 'shortcut', 'position'])]
class Message extends Model
{
    use HasIncrementalCode, SoftDeletes;

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
     * Get the project that owns the message.
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Get the category that owns the message.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the type that owns the message.
     */
    public function type(): BelongsTo
    {
        return $this->belongsTo(MessageType::class, 'message_type_id');
    }

    /**
     * Get the font color that owns the message.
     */
    public function fontColor(): BelongsTo
    {
        return $this->belongsTo(Color::class, 'font_color_id');
    }

    /**
     * Get the background color that owns the message.
     */
    public function backgroundColor(): BelongsTo
    {
        return $this->belongsTo(Color::class, 'background_color_id');
    }

    /**
     * Get the border top color that owns the message.
     */
    public function borderTopColor(): BelongsTo
    {
        return $this->belongsTo(Color::class, 'border_top_color_id');
    }


    /**
     * Get the translations for the message.
     */
    public function translations(): HasMany
    {
        return $this->hasMany(MessageTranslation::class);
    }

    public static function generateCode(Project $project): string
    {
        return static::generateIncrementalCode($project, 'msg');
    }
}
