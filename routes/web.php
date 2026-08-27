<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ItemController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ItemController::class, 'index'])->name('items.index');

Route::middleware('auth')->group(function () {
    Route::get('/mypage', [ProfileController::class, 'index'])
        ->name('profile.index');

    Route::get('/mypage/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/mypage/profile', [ProfileController::class, 'update'])
        ->name('profile.update');
});

Route::get('/', [ItemController::class, 'index'])
    ->name('items.index');

Route::get('/items/{product}', [ItemController::class, 'show'])
    ->name('items.show');

Route::middleware('auth')->group(function () {
    Route::get('/mypage', [ProfileController::class, 'index'])
        ->name('profile.index');

    Route::get('/mypage/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/mypage/profile', [ProfileController::class, 'update'])
        ->name('profile.update');
});