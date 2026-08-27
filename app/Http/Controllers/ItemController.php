<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\View\View;

class ItemController extends Controller
{
    /**
     * 商品一覧を表示する
     */
    public function index(): View
    {
        $products = Product::with([
            'images',
            'purchase',
        ])
            ->latest()
            ->get();

        return view('index', compact('products'));
    }

    /**
     * 商品詳細を表示する
     */
    public function show(Product $product): View
    {
        $product->load([
            'images',
            'categories',
            'likes',
            'comments.user',
            'purchase',
            'user',
        ]);

        return view('show', compact('product'));
    }
}
