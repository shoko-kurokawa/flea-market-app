<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\CreatesTestData;
use Tests\TestCase;

class ProfileUpdateTest extends TestCase
{
    use RefreshDatabase;
    use CreatesTestData;

    public function test_profile_edit_page_displays_existing_values(): void
    {
        $user = $this->createVerifiedUser([
            'name' => '変更前ユーザー',
            'profile_image' => 'profiles/test.jpg',
            'postal_code' => '123-4567',
            'address' => '東京都テスト区1-1',
            'building' => 'テストビル',
        ]);

        $response = $this
            ->actingAs($user)
            ->get(route('profile.edit'));

        $response->assertOk();
        $response->assertSee('変更前ユーザー');
        $response->assertSee('123-4567');
        $response->assertSee('東京都テスト区1-1');
        $response->assertSee('profiles/test.jpg', false);
    }

    public function test_user_can_update_profile_information(): void
    {
        $user = $this->createVerifiedUser();

        $response = $this
            ->actingAs($user)
            ->patch(route('profile.update'), [
                'name' => '変更後ユーザー',
                'postal_code' => '987-6543',
                'address' => '大阪府テスト市2-2',
                'building' => '変更後ビル',
            ]);

        $response->assertRedirect();

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => '変更後ユーザー',
            'postal_code' => '987-6543',
            'address' => '大阪府テスト市2-2',
            'building' => '変更後ビル',
        ]);
    }
}
