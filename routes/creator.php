<?php

use Illuminate\Support\Facades\Route;

Route::prefix('creator')->middleware(['auth', 'creator'])->group(function () {
    Route::get('/', fn () => 'Welcome to the Dashboard');
    Route::get('/stats', fn () => 'Here are your dashboard stats');
});
