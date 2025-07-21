<?php

namespace Tests\Feature\api\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthLoginTest extends TestCase
{
    use RefreshDatabase;

    public function testUserCanLoginWithCorrectCredentials()
    {
        $user = \App\Models\User::factory()->create([
            'email' => 'test@mail.com',
            'password' => bcrypt($password = 'i-love-laravel'),
        ]);

        $payload = [
            'email' => $user->email,
            'password' => $password,
        ];

        $response = $this->postJson('/api/login', $payload);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'data' => [
                    'name',
                    'email',
                    'access_token',
                    'token_type',
                    'expires_in',
                ],
            ]);
    }

    public function testUserCannotLoginWithIncorrectCredentials()
    {
        $user = \App\Models\User::factory()->create([
            'email' => 'test@mail.com',
            'password' => bcrypt('i-love-laravel'),
        ]);

        $payload = [
            'email' => $user->email,
            'password' => 'wrong-password',
        ];

        $response = $this->postJson('/api/login', $payload);

        $response->assertStatus(401)
            ->assertJson([
                'success' => false,
                'message' => 'Email or password is wrong.',
            ]);
    }
}
