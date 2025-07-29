<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserProfileController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::resource('user-profiles', UserProfileController::class);
    
    Route::get('/@{username}', [UserProfileController::class, 'showByUsername'])
    ->where('username', '[A-Za-z0-9_-]+')
    ->name('profiles.public');
    
});

require __DIR__.'/auth.php';
