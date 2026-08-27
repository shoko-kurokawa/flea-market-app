<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * コメントを投稿する
     */
    public function store(
        CommentRequest $request,
        Product $product
    ): RedirectResponse {
        Auth::user()->comments()->create([
            'product_id' => $product->id,
            'content' => $request->comment,
        ]);

        return back();
    }
}