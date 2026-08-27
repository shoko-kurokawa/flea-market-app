<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\CreatesTestData;
use Tests\TestCase;

class CommentTest extends TestCase
{
    use RefreshDatabase;
    use CreatesTestData;

    public function test_logged_in_user_can_post_comment(): void
    {
        $user = $this->createVerifiedUser();
        $seller = $this->createVerifiedUser();
        $product = $this->createProduct($seller);

        $response = $this
            ->actingAs($user)
            ->post(route('comments.store', $product), [
                'comment' => 'とても素敵な商品です',
            ]);

        $response->assertRedirect();

        $this->assertDatabaseHas('comments', [
            'user_id' => $user->id,
            'product_id' => $product->id,
            'content' => 'とても素敵な商品です',
        ]);

        $response = $this
            ->actingAs($user)
            ->get(route('items.show', $product));

        $response->assertSee('とても素敵な商品です');
        $response->assertSee('コメント（1）');
    }

    public function test_guest_cannot_post_comment(): void
    {
        $seller = $this->createVerifiedUser();
        $product = $this->createProduct($seller);

        $response = $this->post(route('comments.store', $product), [
            'comment' => '送信できないコメント',
        ]);

        $response->assertRedirect('/login');

        $this->assertDatabaseMissing('comments', [
            'product_id' => $product->id,
            'content' => '送信できないコメント',
        ]);
    }

    public function test_comment_is_required(): void
    {
        $user = $this->createVerifiedUser();
        $seller = $this->createVerifiedUser();
        $product = $this->createProduct($seller);

        $response = $this
            ->actingAs($user)
            ->from(route('items.show', $product))
            ->post(route('comments.store', $product), [
                'comment' => '',
            ]);

        $response->assertSessionHasErrors([
            'comment' => 'コメントを入力してください',
        ]);
    }

    public function test_comment_must_not_exceed_255_characters(): void
    {
        $user = $this->createVerifiedUser();
        $seller = $this->createVerifiedUser();
        $product = $this->createProduct($seller);

        $response = $this
            ->actingAs($user)
            ->from(route('items.show', $product))
            ->post(route('comments.store', $product), [
                'comment' => str_repeat('あ', 256),
            ]);

        $response->assertSessionHasErrors('comment');
    }
}
