<?php

namespace App\Models;


use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Purchase extends Model
{
    protected $fillable = ['user_id', 'amount', 'reference'];


    /**
     * Relationship back to the user
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
