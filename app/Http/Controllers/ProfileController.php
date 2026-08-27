<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * プロフィール画面を表示
     */
    public function index(Request $request): View
    {
        $user = $request->user();

        $products = $user->products()
            ->with('images')
            ->latest()
            ->get();

        $purchasedProducts = $user->purchases()
            ->with(['product.images'])
            ->latest()
            ->get();

        return view('profile.index', compact(
            'user',
            'products',
            'purchasedProducts'
        ));
    }

    /**
     * プロフィール編集画面を表示
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * プロフィール情報を更新
     */
    public function update(ProfileRequest $request): RedirectResponse
    {
        $user = $request->user();

        $data = $request->validated();

        if ($request->hasFile('profile_image')) {
            $data['profile_image'] = $request
                ->file('profile_image')
                ->store('profile_images', 'public');
        }

        $user->update($data);

        return redirect()->route('profile.edit');
    }
}