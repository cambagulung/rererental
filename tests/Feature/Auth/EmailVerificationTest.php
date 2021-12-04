<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;
use Tests\UserFactory;

class EmailVerificationTest extends TestCase
{
    use RefreshDatabase, UserFactory;

    protected function user(): User
    {
        return $this->userFactory([
            'email_verified_at' => null,
        ]);
    }

    public function test_email_verification_screen_can_be_rendered()
    {
         $this

         ->actingAs($this->user())
         ->get('/verify-email')
         ->assertStatus(200);
    }

    public function test_email_can_be_verified()
    {
        Event::fake();

        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            ['id' => $this->user()->id, 'hash' => sha1($this->user()->email)]
        );

        $response = $this->actingAs($this->user())->get($verificationUrl);

        Event::assertDispatched(Verified::class);

        $this->assertTrue($this->user()->fresh()->hasVerifiedEmail());

        $response->assertRedirect(RouteServiceProvider::HOME.'?verified=1');
    }

    public function test_email_is_not_verified_with_invalid_hash()
    {
        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            ['id' => $this->user()->id, 'hash' => sha1('wrong-email')]
        );

        $this->actingAs($this->user())->get($verificationUrl);

        $this->assertFalse($this->user()->fresh()->hasVerifiedEmail());
    }
}
