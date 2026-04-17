<?php

namespace App\Listeners;


use App\Events\AchievementUnlocked;
use App\Services\BadgeService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class AwardBadge
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(AchievementUnlocked $event): void
    {
        app(BadgeService::class)->check($event->user); // i called a service using dependency injection
    }
}
