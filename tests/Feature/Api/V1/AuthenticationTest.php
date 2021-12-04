<?php

namespace Tests\Feature\Api\V1;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\UserFactory;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase, UserFactory;

    protected string $oken;

    protected function token(bool $wrongPassword = false): string
    {
        return $this->token ?? $this->token = base64_encode(json_encode([
            'email' => $this->userFactory()->email,
            'password' => $wrongPassword ? 'wrong-password' : 'password',
        ]));
    }

    public function test_users_can_create_new_token_for_authentication_with_simple_guard_post_authorization()
    {
        $this

            ->post('/api/v1/auth/token', ['authorization' => $this->token()])
            ->assertStatus(201);

        $this

            ->assertAuthenticated('simple');
    }

    public function test_users_can_create_new_token_for_authentication_with_simple_guard_post_json_authorization()
    {
        $this

            ->postJson('/api/v1/auth/token', ['authorization' => $this->token()])
            ->assertStatus(201);

        $this

            ->assertAuthenticated('simple');
    }

    public function test_users_can_create_new_token_for_authentication_with_simple_guard_bearer_authorization()
    {
        $this

            ->withHeaders([
                'accept'        => 'application/json',
                'authorization' => 'Bearer ' . $this->token()
            ])

            ->post('/api/v1/auth/token')
            ->assertStatus(201);

        $this

            ->assertAuthenticated('simple');
    }

    public function test_users_can_not_authenticate_with_simple_guard_invalid_password()
    {
        $this

            ->withHeader('accept', 'application/json')
            ->post('/api/v1/auth/token', ['authorization' => $this->token(wrongPassword: true)])
            ->assertStatus(401);

        $this

            ->assertGuest('simple');
    }

    public function test_users_can_not_authenticate_with_simple_guard_invalid_token()
    {
        $this

            ->withHeader('accept', 'application/json')
            ->post('/api/v1/auth/token', ['authorization' => 'invalid token'])
            ->assertStatus(401);

        $this

            ->assertGuest('simple');
    }

    public function test_users_can_authenticate_with_sanctum_guard_bearer_authorization()
    {
        $this

            ->withHeaders([
                'accept'        => 'application/json',
                'authorization' => 'Bearer ' . $this
                    ->userFactory()
                    ->createToken('Test')
                    ->plainTextToken
            ])

            ->get('/api/v1/auth/session')
            ->assertStatus(200);

        $this

            ->assertAuthenticated('sanctum');
    }

    public function test_users_can_not_authenticate_with_sanctum_guard_invalid_bearer_authorization()
    {
        $this

            ->withHeaders([
                'accept'        => 'application/json',
                'authorization' => 'Bearer invalid token'
            ])

            ->get('/api/v1/auth/session')
            ->assertStatus(401);

        $this

            ->assertGuest('sanctum');
    }
}
