<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    /**
     * いいねを登録する
     */
    public function store(Product $product): RedirectResponse
    {
        Auth::user()->likes()->firstOrCreate([
            'product_id' => $product->id,
        ]);

        return back();
    }

    /**
     * いいねを解除する
     */
    public function destroy(Product $product): RedirectResponse
    {
        Auth::user()
            ->likes()
            ->where('product_id', $product->id)
            ->delete();

        return back();
    }
}