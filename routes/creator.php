<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CreatorController;

Route::prefix('creator')->middleware(['auth', 'creator'])->group(function () {
    Route::get('/create', [CreatorController::class, 'creatorCreatePost'])
		->name('creator.post.create');
});