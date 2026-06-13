<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['code', 'label'])]
class Role extends Model
{
    /**
     * Get the memberships for the role.
     */
    public function memberships(): HasMany
    {
        return $this->hasMany(Membership::class);
    }
}
