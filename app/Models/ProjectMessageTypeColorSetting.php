<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable(['project_id', 'message_type_id', 'font_color_id', 'background_color_id', 'border_top_color_id'])]
class ProjectMessageTypeColorSetting extends Model
{
    use SoftDeletes;

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function messageType(): BelongsTo
    {
        return $this->belongsTo(MessageType::class);
    }

    public function fontColor(): BelongsTo
    {
        return $this->belongsTo(Color::class, 'font_color_id');
    }

    public function backgroundColor(): BelongsTo
    {
        return $this->belongsTo(Color::class, 'background_color_id');
    }

    public function borderTopColor(): BelongsTo
    {
        return $this->belongsTo(Color::class, 'border_top_color_id');
    }
}
