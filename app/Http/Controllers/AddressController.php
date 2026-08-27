<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddressRequest;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AddressController extends Controller
{
    /**
     * 配送先変更画面を表示する
     */
    public function edit(Product $product): View
    {
        return view('address', compact('product'));
    }

    /**
     * 配送先を更新する
     */
    public function update(
        AddressRequest $request,
        Product $product
    ): RedirectResponse {
        session([
            'shipping_postal_code' => $request->postal_code,
            'shipping_address' => $request->address,
            'shipping_building' => $request->building,
        ]);

        return redirect()
            ->route('purchase.create', $product);
    }
}