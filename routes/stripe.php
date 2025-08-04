<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CreatorController;
use App\Http\Controllers\StripeController;

Route::prefix('creator')->middleware(['auth', 'creator'])->group(function () {
    Route::get('/checkout', [StripeController::class, 'showCheckoutForm'])->name('creator.stripe.checkout');
    Route::post('/checkout', [StripeController::class, 'processCheckout'])->name('creator.stripe.process');
    Route::get('/success', [StripeController::class, 'success'])->name('creator.stripe.success');
    Route::get('/cancel', [StripeController::class, 'cancel'])->name('creator.stripe.cancel');
});

// Route::middleware(['auth'])->group(function () {
    
// });