<?php

namespace App\Services;

use App\Events\BadgeUnlocked;
use App\Models\Badge;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class BadgeService
{

    public function check(User $user)
    {

        $achievementCount = $user->achievements()->count();

        $badges = Badge::orderBy('achievements_required')->get();

        foreach ($badges as $badge) {
            if ($achievementCount >= $badge->achievements_required && !$user->badges->contains($badge->id)) {

                DB::transaction(
                    function () use ($user, $badge) {

                        // Set all previous badges to inactive
                        $user->badges()->updateExistingPivot($user->badges->pluck('id'), ['is_active' => false]);

                        // Attach the new badge as active
                        $user->badges()->attach($badge->id, ['is_active' => true]);
                    }
                );

                BadgeUnlocked::dispatch($user, $badge);
            }
        }
    }
}
