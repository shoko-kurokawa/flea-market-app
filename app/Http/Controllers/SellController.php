<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExhibitionRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class SellController extends Controller
{
    /**
     * 出品画面を表示する
     */
    public function create(): View
    {
        $categories = Category::all();

        return view('sell', compact('categories'));
    }

    /**
     * 商品を出品する
     */
    public function store(ExhibitionRequest $request): RedirectResponse
    {
        DB::transaction(function () use ($request) {
            $product = Product::create([
                'user_id' => Auth::id(),
                'name' => $request->name,
                'brand_name' => $request->brand_name,
                'description' => $request->description,
                'price' => $request->price,
                'condition' => $request->condition,
            ]);

            $product->categories()->attach($request->category_ids);

            $imagePath = $request
                ->file('image')
                ->store('products', 'public');

            $product->images()->create([
                'image_path' => $imagePath,
            ]);
        });

        return redirect()
            ->route('items.index')
            ->with('success', '商品を出品しました。');
    }
}