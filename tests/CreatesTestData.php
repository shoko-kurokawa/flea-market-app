<?php

namespace Tests;

use App\Models\Category;
use App\Models\Image;
use App\Models\Product;
use App\Models\User;

trait CreatesTestData
{
    protected function createVerifiedUser(array $attributes = []): User
    {
        return User::factory()->create(array_merge([
            'email_verified_at' => now(),
        ], $attributes));
    }

    protected function createUnverifiedUser(array $attributes = []): User
    {
        return User::factory()->unverified()->create($attributes);
    }

    protected function createProduct(User $seller, array $attributes = []): Product
    {
        return Product::create(array_merge([
            'user_id' => $seller->id,
            'name' => 'テスト商品',
            'brand_name' => 'テストブランド',
            'description' => 'テスト商品の説明です。',
            'price' => 5000,
            'condition' => '良好',
        ], $attributes));
    }

    protected function addImage(Product $product, string $url = 'https://example.com/product.jpg'): Image
    {
        return Image::create([
            'product_id' => $product->id,
            'image_path' => $url,
        ]);
    }

    protected function createCategory(string $name = 'ファッション'): Category
    {
        return Category::create([
            'name' => $name,
        ]);
    }
}
