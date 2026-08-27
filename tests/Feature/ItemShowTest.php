<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\CreatesTestData;
use Tests\TestCase;

class ItemShowTest extends TestCase
{
    use RefreshDatabase;
    use CreatesTestData;

    public function test_product_detail_displays_required_information(): void
    {
        $seller = $this->createVerifiedUser(['name' => '出品者']);
        $commenter = $this->createVerifiedUser(['name' => 'コメントユーザー']);

        $product = $this->createProduct($seller, [
            'name' => '腕時計',
            'brand_name' => 'Armani',
            'description' => '商品の詳しい説明',
            'price' => 15000,
            'condition' => '良好',
        ]);

        $this->addImage($product);

        $category = $this->createCategory('ファッション');
        $product->categories()->attach($category->id);

        $product->likes()->create([
            'user_id' => $commenter->id,
        ]);

        $commenter->comments()->create([
            'product_id' => $product->id,
            'content' => '素敵な商品です',
        ]);

        $response = $this->get(route('items.show', $product));

        $response->assertOk();
        $response->assertSee('腕時計');
        $response->assertSee('Armani');
        $response->assertSee('15,000');
        $response->assertSee('商品の詳しい説明');
        $response->assertSee('ファッション');
        $response->assertSee('良好');
        $response->assertSee('コメントユーザー');
        $response->assertSee('素敵な商品です');
    }

    public function test_multiple_categories_are_displayed(): void
    {
        $seller = $this->createVerifiedUser();
        $product = $this->createProduct($seller);

        $categoryA = $this->createCategory('ファッション');
        $categoryB = $this->createCategory('メンズ');

        $product->categories()->attach([
            $categoryA->id,
            $categoryB->id,
        ]);

        $response = $this->get(route('items.show', $product));

        $response->assertSee('ファッション');
        $response->assertSee('メンズ');
    }
}
