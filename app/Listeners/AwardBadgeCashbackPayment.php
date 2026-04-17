<?php

namespace App\Listeners;

use App\Events\BadgeUnlocked;
use App\Services\BadgeCashbackPaymentService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class AwardBadgeCashbackPayment
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
    public function handle(BadgeUnlocked $event): void
    {
        app(BadgeCashbackPaymentService::class)->check($event->user); // i called a service using dependency injection
    }
}
