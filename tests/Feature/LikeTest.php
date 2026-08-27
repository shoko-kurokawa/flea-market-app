<?php

namespace Tests\Feature;

use App\Models\Like;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\CreatesTestData;
use Tests\TestCase;

class LikeTest extends TestCase
{
    use RefreshDatabase;
    use CreatesTestData;

    public function test_user_can_like_product(): void
    {
        $user = $this->createVerifiedUser();
        $seller = $this->createVerifiedUser();
        $product = $this->createProduct($seller);

        $response = $this
            ->actingAs($user)
            ->post(route('likes.store', $product));

        $response->assertRedirect();

        $this->assertDatabaseHas('likes', [
            'user_id' => $user->id,
            'product_id' => $product->id,
        ]);

        $response = $this
            ->actingAs($user)
            ->get(route('items.show', $product));

        $response->assertSee('♥');
        $response->assertSee('1');
    }

    public function test_liked_icon_changes_color_class(): void
    {
        $user = $this->createVerifiedUser();
        $seller = $this->createVerifiedUser();
        $product = $this->createProduct($seller);

        Like::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
        ]);

        $response = $this
            ->actingAs($user)
            ->get(route('items.show', $product));

        $response->assertSee('item-detail__like-button--liked', false);
    }

    public function test_user_can_unlike_product(): void
    {
        $user = $this->createVerifiedUser();
        $seller = $this->createVerifiedUser();
        $product = $this->createProduct($seller);

        Like::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
        ]);

        $response = $this
            ->actingAs($user)
            ->delete(route('likes.destroy', $product));

        $response->assertRedirect();

        $this->assertDatabaseMissing('likes', [
            'user_id' => $user->id,
            'product_id' => $product->id,
        ]);
    }
}
