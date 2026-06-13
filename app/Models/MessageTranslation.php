<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['message_id', 'language_id', 'content'])]
class MessageTranslation extends Model
{
    /**
     * Get the message that owns the translation.
     */
    public function message(): BelongsTo
    {
        return $this->belongsTo(Message::class);
    }

    /**
     * Get the language that owns the translation.
     */
    public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class);
    }
}
