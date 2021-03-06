<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_correct_response_after_login()
    {
        $user = factory(User::class)->create();

        $this->postJson('/login', [
            'email' => $user->email,
            'password' => 'password'
        ])->assertStatus(200)
        ->assertJson([
            'status' => 'ok'
        ])->assertSessionHas('success', 'Successfully Logged in.');
    }

    public function test_user_receives_correct_message_when_passing_wrong_credentials()
    {
        $user = factory(User::class)->create();

        $this->postJson('/login', [
            'email' => $user->email,
            'password' => 'wrong-password'
        ])->assertStatus(422)
        ->assertJson([
            'message' => 'These credentials do not match our records.'
        ]);
    }
}
