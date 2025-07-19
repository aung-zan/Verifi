<?php

namespace Tests\Feature\api\User;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserShowTest extends TestCase
{
    use RefreshDatabase;

    public function testAuthenticatedUserCanViewProfile()
    {
        $user = \App\Models\User::factory()->create([
            'email' => 'test@mail.com'
        ]);
        /** @var \Illuminate\Contracts\Auth\Authenticatable $user */
        $token = auth('api')->login($user);

        $response = $this->withHeader('Authorization', "Bearer $token")
            ->getJson('/api/profile');

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data' => [
                    'name' => $user->name,
                    'email' => $user->email,
                ]
            ]);
    }

    public function testUnauthorizedUserCannotViewProfile()
    {
        $response = $this->getJson('/api/profile');

        $response->assertStatus(401);
    }
}
