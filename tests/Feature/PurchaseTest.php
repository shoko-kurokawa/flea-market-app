<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\CreatesTestData;
use Tests\TestCase;

class PurchaseTest extends TestCase
{
    use RefreshDatabase;
    use CreatesTestData;

    public function test_user_can_purchase_product(): void
    {
        $buyer = $this->createVerifiedUser();
        $seller = $this->createVerifiedUser();
        $product = $this->createProduct($seller);

        $response = $this
            ->actingAs($buyer)
            ->post(route('purchase.store', $product), [
                'payment_method' => 'card',
                'shipping_postal_code' => '123-4567',
                'shipping_address' => '東京都テスト区1-1',
                'shipping_building' => 'テストビル101',
            ]);

        $response->assertRedirect(route('items.index'));

        $this->assertDatabaseHas('purchases', [
            'user_id' => $buyer->id,
            'product_id' => $product->id,
            'payment_method' => 'card',
        ]);
    }

    public function test_purchased_product_is_displayed_as_sold(): void
    {
        $buyer = $this->createVerifiedUser();
        $seller = $this->createVerifiedUser();
        $product = $this->createProduct($seller, ['name' => '購入対象']);

        $this
            ->actingAs($buyer)
            ->post(route('purchase.store', $product), [
                'payment_method' => 'card',
                'shipping_postal_code' => '123-4567',
                'shipping_address' => '東京都テスト区1-1',
                'shipping_building' => '',
            ]);

        $response = $this
            ->actingAs($buyer)
            ->get(route('items.index'));

        $response->assertSee('購入対象');
        $response->assertSee('SOLD');
    }

    public function test_purchased_product_is_added_to_profile_purchase_list(): void
    {
        $buyer = $this->createVerifiedUser();
        $seller = $this->createVerifiedUser();
        $product = $this->createProduct($seller, ['name' => 'プロフィール購入商品']);

        $this
            ->actingAs($buyer)
            ->post(route('purchase.store', $product), [
                'payment_method' => 'convenience_store',
                'shipping_postal_code' => '123-4567',
                'shipping_address' => '東京都テスト区1-1',
                'shipping_building' => '',
            ]);

        $response = $this
            ->actingAs($buyer)
            ->get(route('profile.index', ['page' => 'buy']));

        $response->assertSee('プロフィール購入商品');
    }
}
