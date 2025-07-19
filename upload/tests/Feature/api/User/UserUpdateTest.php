<?php

namespace Tests\Feature\api\User;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserUpdateTest extends TestCase
{
    use RefreshDatabase;

    public function testAuthenticatedUserCanUpdateProfile()
    {
        $user = \App\Models\User::factory()->create([
            'email' => 'test@mail.com'
        ]);
        /** @var \Illuminate\Contracts\Auth\Authenticatable $user */
        $token = auth('api')->login($user);

        $payload = [
            'name' => 'Updated Name',
        ];

        $response = $this->withHeader('Authorization', "Bearer $token")
            ->putJson('/api/profile', $payload);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data' => [
                    'name' => 'Updated Name',
                    'email' => $user->email,
                ]
            ]);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Updated Name',
        ]);
    }

    public function testUnauthorizedUserCannotUpdateProfile()
    {
        $payload = [
            'name' => 'Updated Name',
        ];

        $response = $this->putJson('/api/profile', $payload);

        $response->assertStatus(401);
    }
}
