<?php

namespace Tests\Feature;

use App\Models\Purchase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\CreatesTestData;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;
    use CreatesTestData;

    public function test_profile_displays_user_information_and_product_lists(): void
    {
        $user = $this->createVerifiedUser([
            'name' => 'プロフィールユーザー',
            'profile_image' => 'profiles/test.jpg',
        ]);
        $otherUser = $this->createVerifiedUser();

        $sellingProduct = $this->createProduct($user, [
            'name' => '出品した商品',
        ]);

        $purchasedProduct = $this->createProduct($otherUser, [
            'name' => '購入した商品',
        ]);

        Purchase::create([
            'user_id' => $user->id,
            'product_id' => $purchasedProduct->id,
            'payment_method' => 'card',
            'shipping_postal_code' => '123-4567',
            'shipping_address' => '東京都テスト区',
            'shipping_building' => null,
        ]);

        $response = $this
            ->actingAs($user)
            ->get(route('profile.index'));

        $response->assertOk();
        $response->assertSee('プロフィールユーザー');
        $response->assertSee('profiles/test.jpg', false);
        $response->assertSee('出品した商品');

        $response = $this
            ->actingAs($user)
            ->get(route('profile.index', ['page' => 'buy']));

        $response->assertSee('購入した商品');
    }
}
