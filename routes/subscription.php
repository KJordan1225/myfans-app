<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SubscriptionController;

Route::prefix('subscription')->middleware(['auth'])->group(function () {
    Route::post('/store', [SubscriptionController::class, 'store'])->name('subscription.store');
    Route::get('/subscribe', [SubscriptionController::class, 'create'])->name('subscription.create');
});