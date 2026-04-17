<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Achievement;
use App\Models\AchievementUser;
use App\Models\Badge;
use App\Models\BadgeUser;
use App\Models\Purchase;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function achievements(): BelongsToMany
    {
        return $this->belongsToMany(Achievement::class)
            ->using(AchievementUser::class)
            ->withTimestamps();
    }

    public function badges(): BelongsToMany
    {
        return $this->belongsToMany(Badge::class)
            ->using(BadgeUser::class)
            ->withPivot('is_active')
            ->withTimestamps();
    }

    // Accessor function
    public function getCurrentBadgeAttribute()
    {
        return $this->badges()->wherePivot('is_active', true)->first();
    }

    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }
}
