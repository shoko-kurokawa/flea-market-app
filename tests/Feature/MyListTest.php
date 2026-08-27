<?php

namespace Tests\Feature;

use App\Models\Like;
use App\Models\Purchase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\CreatesTestData;
use Tests\TestCase;

class MyListTest extends TestCase
{
    use RefreshDatabase;
    use CreatesTestData;

    public function test_only_liked_products_are_displayed(): void
    {
        $user = $this->createVerifiedUser();
        $seller = $this->createVerifiedUser();

        $liked = $this->createProduct($seller, ['name' => 'いいね商品']);
        $notLiked = $this->createProduct($seller, ['name' => '未いいね商品']);

        Like::create([
            'user_id' => $user->id,
            'product_id' => $liked->id,
        ]);

        $response = $this
            ->actingAs($user)
            ->get(route('items.index', ['page' => 'mylist']));

        $response->assertSee($liked->name);
        $response->assertDontSee($notLiked->name);
    }

    public function test_purchased_liked_product_has_sold_label(): void
    {
        $user = $this->createVerifiedUser();
        $seller = $this->createVerifiedUser();
        $buyer = $this->createVerifiedUser();

        $product = $this->createProduct($seller, ['name' => '購入済みマイリスト商品']);

        Like::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
        ]);

        Purchase::create([
            'user_id' => $buyer->id,
            'product_id' => $product->id,
            'payment_method' => 'card',
            'shipping_postal_code' => '123-4567',
            'shipping_address' => '東京都テスト区1-1',
            'shipping_building' => null,
        ]);

        $response = $this
            ->actingAs($user)
            ->get(route('items.index', ['page' => 'mylist']));

        $response->assertSee('購入済みマイリスト商品');
        $response->assertSee('SOLD');
    }

    public function test_guest_sees_no_products_in_mylist(): void
    {
        $seller = $this->createVerifiedUser();
        $product = $this->createProduct($seller, ['name' => '表示されない商品']);

        $response = $this->get(route('items.index', ['page' => 'mylist']));

        $response->assertOk();
        $response->assertDontSee($product->name);
    }
}
