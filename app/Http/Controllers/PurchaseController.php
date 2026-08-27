<?php

namespace App\Http\Controllers;

use App\Http\Requests\PurchaseRequest;
use App\Models\Product;
use App\Models\Purchase;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PurchaseController extends Controller
{
    /**
     * 購入画面を表示する
     */
    public function create(Product $product): View
    {
        $product->load('images');

        $user = Auth::user();

        return view('purchase', compact('product', 'user'));
    }

    /**
     * 商品を購入する
     */
    public function store(
        PurchaseRequest $request,
        Product $product
    ): RedirectResponse {
        if ($product->purchase) {
            return redirect()
                ->route('items.index')
                ->with('error', 'この商品はすでに購入されています。');
        }

        Purchase::create([
            'user_id' => Auth::id(),
            'product_id' => $product->id,
            'payment_method' => $request->payment_method,
            'shipping_postal_code' => $request->shipping_postal_code,
            'shipping_address' => $request->shipping_address,
            'shipping_building' => $request->shipping_building,
        ]);

        return redirect()
            ->route('items.index')
            ->with('success', '商品を購入しました。');
    }
}
