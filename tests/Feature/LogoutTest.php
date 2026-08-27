<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\CreatesTestData;
use Tests\TestCase;

class LogoutTest extends TestCase
{
    use RefreshDatabase;
    use CreatesTestData;

    public function test_logged_in_user_can_logout(): void
    {
        $user = $this->createVerifiedUser();

        $response = $this
            ->actingAs($user)
            ->post('/logout');

        $response->assertRedirect();
        $this->assertGuest();
    }
}
