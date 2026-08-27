<?php

namespace Tests\Feature;

use App\Models\Like;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\CreatesTestData;
use Tests\TestCase;

class ItemSearchTest extends TestCase
{
    use RefreshDatabase;
    use CreatesTestData;

    public function test_products_can_be_searched_by_partial_name(): void
    {
        $seller = $this->createVerifiedUser();

        $this->createProduct($seller, ['name' => '高級腕時計']);
        $this->createProduct($seller, ['name' => 'ノートPC']);

        $response = $this->get(route('items.index', [
            'keyword' => '腕',
        ]));

        $response->assertSee('高級腕時計');
        $response->assertDontSee('ノートPC');
    }

    public function test_search_keyword_is_kept_on_mylist(): void
    {
        $user = $this->createVerifiedUser();
        $seller = $this->createVerifiedUser();

        $product = $this->createProduct($seller, ['name' => '高級腕時計']);

        Like::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
        ]);

        $response = $this
            ->actingAs($user)
            ->get(route('items.index', [
                'page' => 'mylist',
                'keyword' => '腕',
            ]));

        $response->assertOk();
        $response->assertSee('高級腕時計');
        $response->assertSee('value="腕"', false);
    }
}
