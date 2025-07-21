<?php

namespace Tests\Feature\api\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthLogoutTest extends TestCase
{
    use RefreshDatabase;

    public function testUserCanLogout()
    {
        $user = \App\Models\User::factory()->create([
            'email' => 'test@mail.com',
        ]);
        /** @var \Illuminate\Contracts\Auth\Authenticatable $user */
        $token = auth('api')->login($user);

        $response = $this->withHeader('Authorization', "Bearer $token")
            ->postJson('/api/logout');

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Successfully logout.',
            ]);
    }
}
