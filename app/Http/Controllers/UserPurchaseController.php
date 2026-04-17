<?php

namespace App\Http\Controllers;

use App\Events\PurchaseMade;
use App\Models\Purchase;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UserPurchaseController extends Controller
{


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, User $user)
    {

        // 1. Validate the incoming request
        $validated = $request->validate([
            'amount' => 'required|numeric|min:1',
        ]);

        // 2. Create the purchase
        // Note: Our Purchase Model's $dispatchesEvents will automatically
        // trigger the 'PurchaseProcessed' event upon creation.
        $purchase = Purchase::create([
            'user_id'   => $user->id,
            'amount'    => $validated['amount'],
            'reference' => 'TXN_' . Str::random(10),
        ]);

        // Fire event
        PurchaseMade::dispatch($user, $purchase);

        return response()->json([
            'message' => 'Purchase successful!',
            'data' => [
                'purchase_id' => $purchase->id,
                'amount'      => $purchase->amount,
                'reference'   => $purchase->reference,
                'total_purchases_now' => $user->purchases()->count()
            ]
        ], 201);
    }
}
