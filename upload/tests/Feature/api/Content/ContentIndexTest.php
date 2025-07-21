<?php

namespace Tests\Feature\api\Content;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContentIndexTest extends TestCase
{
    use RefreshDatabase;

    public function testAuthenticatedUserCanListContent()
    {
        $user = \App\Models\User::factory()->create([
            'email' => 'test@mail.com',
        ]);
        /** @var \Illuminate\Contracts\Auth\Authenticatable $user */
        $token = auth('api')->login($user);

        \App\Models\Content::factory()->count(3)->for($user)->create();

        $response = $this->withHeader('Authorization', "Bearer $token")
            ->getJson('/api/content');

        $response->assertStatus(200)
            ->assertJsonCount(3, 'data.contents')
            ->assertJsonStructure([
                'success',
                'data' => [
                    'contents' => [
                        '*' => [
                            'id',
                            'content',
                            'user_id',
                            'created_at',
                            'updated_at',
                        ],
                    ],
                ],
            ]);
    }

    public function testUnauthorizedUserCannotListContent()
    {
        $response = $this->getJson('/api/content');

        $response->assertStatus(401);
    }

    public function testFilterListContent()
    {
        $user = \App\Models\User::factory()->create([
            'email' => 'test@mail.com',
        ]);
        /** @var \Illuminate\Contracts\Auth\Authenticatable $user */
        $token = auth('api')->login($user);

        \App\Models\Content::factory()->for($user)->create([
            'status' => 0,
        ]);
        \App\Models\Content::factory()->for($user)->create([
            'status' => 1,
        ]);

        $response = $this->withHeader('Authorization', "Bearer $token")
            ->getJson('/api/content?status=1');

        $response->assertStatus(200)
            ->assertJsonCount(1, 'data.contents')
            ->assertJsonStructure([
                'success',
                'data' => [
                    'contents' => [
                        '*' => [
                            'id',
                            'content',
                            'user_id',
                            'created_at',
                            'updated_at',
                        ],
                    ],
                ],
            ]);
    }
}
