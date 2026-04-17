<?php

namespace App\Services;

use App\Events\AchievementUnlocked;
use App\Models\Achievement;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class AchievementService
{

    public function check(User $user)
    {
        $achievements = Achievement::all();

        $purchase_count = $user->purchases()->count();

        foreach ($achievements as $achievement) {
            if (
                $purchase_count >= $achievement->required_purchases &&
                !$user->achievements->contains($achievement->id)
            ) {

                DB::transaction(
                    function () use ($user, $achievement) {
                        $user->achievements()->attach($achievement->id);

                        AchievementUnlocked::dispatch($user, $achievement);
                    }
                );
            }
        }
    }
}
