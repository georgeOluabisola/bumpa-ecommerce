<?php

use App\Http\Controllers\UserAchievementController;
use App\Http\Controllers\UserPurchaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('users.achievements', UserAchievementController::class)->only([
    'index',
]);

Route::apiResource('users.purchases', UserPurchaseController::class)->only([
    'store',
]);



Route::middleware(['auth:sanctum'])->group(function () {});
