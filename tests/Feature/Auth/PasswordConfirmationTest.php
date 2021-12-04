<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\UserFactory;

class PasswordConfirmationTest extends TestCase
{
    use RefreshDatabase, UserFactory;

    public function test_confirm_password_screen_can_be_rendered()
    {
        $this

            ->actingAs($this->userFactory())
            ->get('/confirm-password')
            ->assertStatus(200);
    }

    public function test_password_can_be_confirmed()
    {


        $this

            ->actingAs($this->userFactory())
            ->post('/confirm-password', ['password' => 'password'])
            ->assertRedirect()
            ->assertSessionHasNoErrors();
    }

    public function test_password_is_not_confirmed_with_invalid_password()
    {
        $this

            ->actingAs($this->userFactory())
            ->post('/confirm-password', ['password' => 'wrong-password'])
            ->assertSessionHasErrors();
    }
}
