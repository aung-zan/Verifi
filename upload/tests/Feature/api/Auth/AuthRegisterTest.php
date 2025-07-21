<?php

namespace Tests\Feature\api\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthRegisterTest extends TestCase
{
    use RefreshDatabase;

    public function testUserCanRegister()
    {
        $payload = [
            'name' => 'Test User',
            'email' => 'test@mail.com',
            'confirm_email' => 'test@mail.com',
            'password' => 'password',
            'confirm_password' => 'password',
        ];

        $response = $this->postJson('/api/register', $payload);

        $response->assertStatus(201)
            ->assertJson([
                'success' => true,
                'data' => [
                    'name' => 'Test User',
                    'email' => 'test@mail.com',
                ],
            ]);

        $this->assertDatabaseHas('users', [
            'name' => 'Test User',
            'email' => 'test@mail.com',
        ]);
    }

    public function testCannotRegisterWithExistingEmail()
    {
        \App\Models\User::factory()->create(['email' => 'test@mail.com']);

        $payload = [
            'name' => 'Test User',
            'email' => 'test@mail.com',
            'confirm_email' => 'test@mail.com',
            'password' => 'password',
            'confirm_password' => 'password',
        ];

        $response = $this->postJson('/api/register', $payload);

        $response->assertStatus(422)
            ->assertJsonFragments([
                ['success' => false],
                ['field' => 'email'],
            ]);
    }
}
