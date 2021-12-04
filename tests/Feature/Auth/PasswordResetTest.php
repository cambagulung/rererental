<?php

namespace Tests\Feature\Auth;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;
use Tests\UserFactory;

class PasswordResetTest extends TestCase
{
    use RefreshDatabase, UserFactory;

    public function test_reset_password_link_screen_can_be_rendered()
    {
        $this

            ->get('/forgot-password')
            ->assertStatus(200);
    }

    public function test_reset_password_link_can_be_requested()
    {
        Notification::fake();

        $this->post('/forgot-password', ['email' => $this->userFactory()->email]);

        Notification::assertSentTo($this->userFactory(), ResetPassword::class);
    }

    public function test_reset_password_screen_can_be_rendered()
    {
        Notification::fake();

        $this->post('/forgot-password', ['email' => $this->userFactory()->email]);

        Notification::assertSentTo($this->userFactory(), ResetPassword::class, function ($notification)
        {
            $response = $this->get('/reset-password/' . $notification->token);

            $response->assertStatus(200);

            return true;
        });
    }

    public function test_password_can_be_reset_with_valid_token()
    {
        Notification::fake();

        $this->post('/forgot-password', ['email' => $this->userFactory()->email]);

        Notification::assertSentTo($this->userFactory(), ResetPassword::class, function ($notification)
        {
            $this

                ->post('/reset-password', [
                    'token' => $notification->token,
                    'email' => $this->userFactory()->email,
                    'password' => 'password',
                    'password_confirmation' => 'password',
                ])

                ->assertSessionHasNoErrors();

            return true;
        });
    }
}
