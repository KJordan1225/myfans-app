<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CreatorController;

Route::prefix('creator')->middleware(['auth', 'creator'])->group(function () {
    Route::get('/create', [CreatorController::class, 'creatorCreatePost'])
		  ->name('creator.post.create');
    Route::get('/create/media', [CreatorController::class, 'creatorCreateMedia'])
		  ->name('creator.media.create');
    Route::post('/create', [CreatorController::class, 'creatorStorePost'])
		  ->name('creator.post.store');
});