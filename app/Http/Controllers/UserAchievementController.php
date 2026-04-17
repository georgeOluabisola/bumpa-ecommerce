<?php

namespace App\Http\Controllers;

use App\Models\Achievement;
use App\Models\Badge;
use App\Models\Purchase;
use App\Models\User;
use Illuminate\Http\Request;

class UserAchievementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, User $user)
    {
        //  Get Unlocked Achievements
        $unlockedAchievements = $user->achievements->pluck('name')->toArray();

        //  Get Next Available Achievements. We find achievements the user hasn't unlocked yet, sorted by the requirement
        $nextAvailableAchievements = Achievement::whereNotIn('name', $unlockedAchievements)
            ->orderBy('requirement', 'asc')
            ->pluck('name')->toArray();


        //  Current Badge 
        // Accessing via the 'badges' relationship where pivot 'is_active' is true
        $currentBadgeModel = $user->badges()
            ->wherePivot('is_active', true)
            ->first();

        //  Next Badge
        $unlockedAchievementsCount = count($unlockedAchievements);


        $nextBadge = Badge::where('achievements_required', '>', $unlockedAchievementsCount)
            ->orderBy('achievements_required', 'asc')
            ->first();


        //remaining to unlock next badge
        $remainingToUnlockNextBadge = $nextBadge
            ? ($nextBadge->achievements_required - $user->achievements()->count())
            : 0;


        //total purchase
        $totalPurchase = Purchase::count();


        return response()->json([
            'unlocked_achievements' => $unlockedAchievements,
            'next_available_achievements' => $nextAvailableAchievements,
            'current_badge' => $currentBadgeModel,
            'next_badge' => $nextBadge?->name,
            'remaining_to_unlock_next_badge' => $remainingToUnlockNextBadge,
            'total_purchase' => $totalPurchase
        ]);
    }
}
