<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CreatorController;

Route::prefix('creator')->middleware(['auth', 'creator'])->group(function () {
    Route::get('/create', [CreatorController::class, 'creatorCreatePost'])
		  ->name('creator.post.create');
    Route::get('/create/media', [CreatorController::class, 'creatorCreateMedia'])
		  ->name('creator.media.create');
    Route::get('/create/media/list', [CreatorController::class, 'creatorListMedia'])
		  ->name('creator.media.list');
    Route::get('/auth/posts/list', [CreatorController::class, 'listAuthUserPosts'])
		  ->name('creator.auth.posts.list');
    Route::post('/create', [CreatorController::class, 'creatorStorePost'])
		  ->name('creator.post.store');
    Route::post('/create/media', [CreatorController::class, 'creatorStoreMedia'])
		  ->name('creator.media.store');
    Route::get('/posts/{post}/edit', [CreatorController::class, 'creatorEditPost'])
          ->name('creator.post.edit');
});