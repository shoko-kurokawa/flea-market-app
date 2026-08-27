<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\SellController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| 商品一覧・商品詳細
|--------------------------------------------------------------------------
*/

Route::get('/', [ItemController::class, 'index'])
    ->name('items.index');

Route::get('/items/{product}', [ItemController::class, 'show'])
    ->name('items.show');

/*
|--------------------------------------------------------------------------
| ログイン必須+メール認証必須
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified'])->group(function () {

    // プロフィール
    Route::get('/mypage', [ProfileController::class, 'index'])
        ->name('profile.index');

    Route::get('/mypage/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/mypage/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    // いいね
    Route::post('/items/{product}/like', [LikeController::class, 'store'])
        ->name('likes.store');

    Route::delete('/items/{product}/like', [LikeController::class, 'destroy'])
        ->name('likes.destroy');

    // コメント
    Route::post('/items/{product}/comments', [CommentController::class, 'store'])
        ->name('comments.store');

    // 購入
    Route::get('/purchase/{product}', [PurchaseController::class, 'create'])
        ->name('purchase.create');

    Route::post('/purchase/{product}', [PurchaseController::class, 'store'])
        ->name('purchase.store');

    Route::get('/purchase/{product}/address', [AddressController::class, 'edit'])
        ->name('purchase.address.edit');

    Route::patch('/purchase/{product}/address', [AddressController::class, 'update'])
        ->name('purchase.address.update');

    // 出品
    Route::get('/sell', [SellController::class, 'create'])
        ->name('sell.create');

    Route::post('/sell', [SellController::class, 'store'])
        ->name('sell.store');
});