<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\CommentController;
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

Route::middleware('auth')->group(function () {
    Route::get('/mypage', [ProfileController::class, 'index'])
        ->name('profile.index');

    Route::get('/mypage/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/mypage/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::post('/items/{product}/like', [LikeController::class, 'store'])
        ->name('likes.store');

    Route::delete('/items/{product}/like', [LikeController::class, 'destroy'])
        ->name('likes.destroy');

    Route::post('/items/{product}/comments', [CommentController::class, 'store'])
        ->name('comments.store');
});