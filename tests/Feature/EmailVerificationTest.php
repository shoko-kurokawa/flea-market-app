<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Events\Verified;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\URL;
use Tests\CreatesTestData;
use Tests\TestCase;

class EmailVerificationTest extends TestCase
{
    use RefreshDatabase;
    use CreatesTestData;

    public function test_verification_email_is_sent_after_registration_event(): void
    {
        Notification::fake();

        $user = $this->createUnverifiedUser([
            'email' => 'verify@example.com',
        ]);

        event(new Registered($user));

        Notification::assertSentTo(
            $user,
            VerifyEmail::class
        );
    }

    public function test_verification_notice_has_link_to_mailpit(): void
    {
        $user = $this->createUnverifiedUser();

        $response = $this
            ->actingAs($user)
            ->get('/email/verify');

        $response->assertOk();
        $response->assertSee('認証はこちらから');
        $response->assertSee('http://localhost:8025', false);
    }

    public function test_email_verification_redirects_to_profile_edit(): void
    {
        $user = $this->createUnverifiedUser();

        Event::fake();

        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            [
                'id' => $user->id,
                'hash' => sha1($user->email),
            ]
        );

        $response = $this
            ->actingAs($user)
            ->get($verificationUrl);

        $this->assertTrue(
            $user->fresh()->hasVerifiedEmail()
        );

        Event::assertDispatched(Verified::class);

        // 仕様：メール認証完了後はプロフィール設定画面へ遷移。
        $response->assertRedirect(route('profile.edit'));
    }
}
