<?php

namespace Tests\Feature;

use App\Models\Purchase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\CreatesTestData;
use Tests\TestCase;

class ItemIndexTest extends TestCase
{
    use RefreshDatabase;
    use CreatesTestData;

    public function test_all_products_are_displayed_for_guest(): void
    {
        $seller = $this->createVerifiedUser();
        $productA = $this->createProduct($seller, ['name' => '腕時計']);
        $productB = $this->createProduct($seller, ['name' => 'ノートPC']);

        $response = $this->get(route('items.index'));

        $response->assertOk();
        $response->assertSee('腕時計');
        $response->assertSee('ノートPC');
    }

    public function test_purchased_product_has_sold_label(): void
    {
        $seller = $this->createVerifiedUser();
        $buyer = $this->createVerifiedUser();

        $product = $this->createProduct($seller, ['name' => '購入済み商品']);

        Purchase::create([
            'user_id' => $buyer->id,
            'product_id' => $product->id,
            'payment_method' => 'card',
            'shipping_postal_code' => '123-4567',
            'shipping_address' => '東京都テスト区1-1',
            'shipping_building' => null,
        ]);

        $response = $this->get(route('items.index'));

        $response->assertSee('購入済み商品');
        $response->assertSee('SOLD');
    }

    public function test_logged_in_users_own_product_is_not_displayed(): void
    {
        $user = $this->createVerifiedUser();
        $otherSeller = $this->createVerifiedUser();

        $ownProduct = $this->createProduct($user, ['name' => '自分の商品']);
        $otherProduct = $this->createProduct($otherSeller, ['name' => '他人の商品']);

        $response = $this
            ->actingAs($user)
            ->get(route('items.index'));

        $response->assertDontSee($ownProduct->name);
        $response->assertSee($otherProduct->name);
    }
}
