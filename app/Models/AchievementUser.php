<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class AchievementUser extends Pivot
{
    protected $table = 'achievement_user';
    public $incrementing = true;
}
