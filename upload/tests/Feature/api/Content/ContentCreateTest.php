<?php

namespace Tests\Feature\api\Content;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContentCreateTest extends TestCase
{
    use \Illuminate\Foundation\Testing\WithFaker;
    use RefreshDatabase;

    public function testAuthenticatedUserCanCreateContent()
    {
        $user = \App\Models\User::factory()->create([
            'email' => 'test@mail.com',
        ]);
        /** @var \Illuminate\Contracts\Auth\Authenticatable $user */
        $token = auth('api')->login($user);

        $payload = [
            'content' => 'Test content',
        ];

        $response = $this->withHeader('Authorization', "Bearer $token")
            ->postJson('/api/content', $payload);

        $response->assertStatus(201)
            ->assertJson([
                'success' => true,
                'data' => [
                    'content' => 'Test content',
                    'user_id' => $user->id,
                ],
            ]);

        $this->assertDatabaseHas('contents', [
            'content' => 'Test content',
            'user_id' => $user->id,
        ]);
    }

    public function testCannotCreateContentWithoutContentField()
    {
        $user = \App\Models\User::factory()->create([
            'email' => 'test@mail.com',
        ]);
        /** @var \Illuminate\Contracts\Auth\Authenticatable $user */
        $token = auth('api')->login($user);

        $payload = [];

        $response = $this->withHeader('Authorization', "Bearer $token")
            ->postJson('/api/content', $payload);

        $response->assertStatus(422)
            ->assertJsonFragments([
                ['success' => false],
                ['field' => 'content'],
            ]);
    }

    public function testUnauthorizedUserCannotCreateContent()
    {
        $payload = [
            'content' => 'Unauthorized content',
        ];

        $response = $this->postJson('/api/content', $payload);

        $response->assertStatus(401);
    }
}
