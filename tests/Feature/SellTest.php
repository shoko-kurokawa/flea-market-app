<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\CreatesTestData;
use Tests\TestCase;

class SellTest extends TestCase
{
    use RefreshDatabase;
    use CreatesTestData;

    public function test_user_can_sell_product_with_required_information(): void
    {
        Storage::fake('public');

        $user = $this->createVerifiedUser();
        $categoryA = $this->createCategory('ファッション');
        $categoryB = $this->createCategory('メンズ');

        $response = $this
            ->actingAs($user)
            ->post(route('sell.store'), [
                'image' => UploadedFile::fake()->image('product.jpg'),
                'category_ids' => [
                    $categoryA->id,
                    $categoryB->id,
                ],
                'condition' => '良好',
                'name' => '新規出品商品',
                'brand_name' => 'テストブランド',
                'description' => '出品商品の説明です。',
                'price' => 9800,
            ]);

        $response->assertRedirect(route('items.index'));

        $this->assertDatabaseHas('products', [
            'user_id' => $user->id,
            'name' => '新規出品商品',
            'brand_name' => 'テストブランド',
            'description' => '出品商品の説明です。',
            'price' => 9800,
            'condition' => '良好',
        ]);

        $productId = \App\Models\Product::where('name', '新規出品商品')->value('id');

        $this->assertDatabaseHas('product_category', [
            'product_id' => $productId,
            'category_id' => $categoryA->id,
        ]);

        $this->assertDatabaseHas('product_category', [
            'product_id' => $productId,
            'category_id' => $categoryB->id,
        ]);

        $this->assertDatabaseHas('images', [
            'product_id' => $productId,
        ]);
    }
}
