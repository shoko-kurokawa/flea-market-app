<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\CreatesTestData;
use Tests\TestCase;

class PaymentMethodTest extends TestCase
{
    use RefreshDatabase;
    use CreatesTestData;

    public function test_purchase_page_contains_payment_method_reflection_elements(): void
    {
        $buyer = $this->createVerifiedUser([
            'postal_code' => '123-4567',
            'address' => '東京都テスト区1-1',
        ]);
        $seller = $this->createVerifiedUser();
        $product = $this->createProduct($seller);
        $this->addImage($product);

        $response = $this
            ->actingAs($buyer)
            ->get(route('purchase.create', $product));

        $response->assertOk();
        $response->assertSee('id="payment-method"', false);
        $response->assertSee('id="selected-payment-method"', false);
        $response->assertSee('コンビニ払い');
        $response->assertSee('カード支払い');

        // Laravel Feature Test はブラウザ上の JavaScript 自体は実行しないため、
        // 実際の即時反映は手動確認済みの挙動を対象とします。
        $response->assertSee('updatePaymentMethod', false);
    }
}
