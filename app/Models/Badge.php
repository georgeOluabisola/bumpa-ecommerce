<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Badge extends Model
{
    protected $fillable = ['name', 'achievements_required'];

    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'current_badge_id');
    }
}
