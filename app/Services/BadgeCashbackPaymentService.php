<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Log;

class BadgeCashbackPaymentService
{

    public function check(User $user)
    {

        $cashBackAmount = config("settings.CASH_BACK_AMOUNT");
        $currency = "NGN";

        // Mocking the payment logic
        Log::info("CASHBACK SUCCESSFUL", [
            'user_id' => $user->id,
            'user_email' => $user->email,
            'badge' => $user->current_badge,
            'cash_back_amount' => "{$currency} {$cashBackAmount}",
            'timestamp' => now()
        ]);

        // In a real application, i might call:
        // PaymentGateway::pay($user, $amount);
    }
}
