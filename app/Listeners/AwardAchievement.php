<?php

namespace App\Listeners;

use App\Events\PurchaseMade;
use App\Services\AchievementService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class AwardAchievement
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
    public function handle(PurchaseMade $event): void
    {
        app(AchievementService::class)->check($event->user); // i called a service using dependency injection
    }
}
