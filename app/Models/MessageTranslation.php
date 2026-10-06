<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'message_id',
    'language_id',
    'content'
    ])
]
class MessageTranslation extends Model
{
    // BELONGS TO
    public function message(): BelongsTo
    {
        return $this->belongsTo(Message::class);
    }

    public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class);
    }
}
