<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;


    public function test_user_has_username_after_register()
    {
        $name = 'Hesham Yahia';
        $this->post('/register',[
            'name' => $name,
            'email' => 'heshamyahia@gmail.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ])->assertRedirect();

        $this->assertDatabaseHas('users', [
            'username' => str_slug($name)
        ]);
    }
}
