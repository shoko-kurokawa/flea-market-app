<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\CreatesTestData;
use Tests\TestCase;

class AddressTest extends TestCase
{
    use RefreshDatabase;
    use CreatesTestData;

    public function test_changed_shipping_address_is_reflected_on_purchase_page(): void
    {
        $buyer = $this->createVerifiedUser([
            'postal_code' => '111-1111',
            'address' => '旧住所',
        ]);
        $seller = $this->createVerifiedUser();
        $product = $this->createProduct($seller);
        $this->addImage($product);

        $response = $this
            ->actingAs($buyer)
            ->patch(route('purchase.address.update', $product), [
                'postal_code' => '123-4567',
                'address' => '東京都新宿区1-2-3',
                'building' => 'テストマンション101',
            ]);

        $response->assertRedirect(route('purchase.create', $product));

        $response = $this
            ->actingAs($buyer)
            ->get(route('purchase.create', $product));

        $response->assertSee('123-4567');
        $response->assertSee('東京都新宿区1-2-3');
        $response->assertSee('テストマンション101');
    }

    public function test_shipping_address_is_saved_with_purchase(): void
    {
        $buyer = $this->createVerifiedUser();
        $seller = $this->createVerifiedUser();
        $product = $this->createProduct($seller);

        $this
            ->actingAs($buyer)
            ->patch(route('purchase.address.update', $product), [
                'postal_code' => '123-4567',
                'address' => '東京都新宿区1-2-3',
                'building' => 'テストマンション101',
            ]);

        $response = $this
            ->actingAs($buyer)
            ->post(route('purchase.store', $product), [
                'payment_method' => 'card',
                'shipping_postal_code' => '123-4567',
                'shipping_address' => '東京都新宿区1-2-3',
                'shipping_building' => 'テストマンション101',
            ]);

        $response->assertRedirect(route('items.index'));

        $this->assertDatabaseHas('purchases', [
            'user_id' => $buyer->id,
            'product_id' => $product->id,
            'shipping_postal_code' => '123-4567',
            'shipping_address' => '東京都新宿区1-2-3',
            'shipping_building' => 'テストマンション101',
        ]);
    }
}
