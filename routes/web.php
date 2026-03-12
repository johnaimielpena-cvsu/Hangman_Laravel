<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GameController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\AuthController;

Route::prefix('register')->name('register.')->group(function(){
    Route::get('/', [RegistrationController::class, 'show'])->name('show');
    Route::post('/', [RegistrationController::class, 'store'])->name('store');
});

Route::prefix('login')->name('login.')->group(function(){
    Route::get('/', [AuthController::class, 'show'])->name('show');
    Route::post('/', [AuthController::class, 'store'])->name('store');
});

Route::post('/logout', [AuthController::class, 'destroy'])
    ->name('logout')
    ->middleware('auth');

Route::middleware('auth')->group(function(){
    Route::resource('games', GameController::class)->only([
        'index', 'create', 'store', 'edit', 'update', 'destroy'
    ]);

    Route::prefix('games')->name('games.')->group(function(){
        Route::get('/hangman', [GameController::class, 'show'])->name('hangman');
    });
});