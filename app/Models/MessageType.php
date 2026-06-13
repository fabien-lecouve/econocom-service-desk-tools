<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['code', 'label'])]
class MessageType extends Model
{
    /**
     * Get the messages for the type.
     */
    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }
}
