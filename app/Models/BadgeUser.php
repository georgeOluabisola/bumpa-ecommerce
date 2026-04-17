<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class BadgeUser extends Pivot
{
    protected $table = 'badge_user';
    public $incrementing = true;

    protected $fillable = [
        'user_id',
        'badge_id',
        'is_active'
    ];
}
