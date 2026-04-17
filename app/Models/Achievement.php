<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Achievement extends Model
{
    protected $fillable = ['name', 'required_purchases'];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }
}
