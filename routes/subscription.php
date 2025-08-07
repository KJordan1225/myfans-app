<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SubscriptionController;

Route::prefix('subscription')->middleware(['auth'])->group(function () {
    Route::post('/store', [SubscriptionController::class, 'store'])->name('subscription.store');
    Route::get('/create', [SubscriptionController::class, 'create'])->name('subscription.create');
    Route::get('/creator/{creator}/plans', [SubscriptionController::class, 'showPlans'])->name('creator.plans');
Route::post('/subscribe', [SubscriptionController::class, 'subscribe'])->name('subscription.create');
});