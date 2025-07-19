<?php

namespace Tests\Feature\api\Content;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContentUpdateTest extends TestCase
{
    use RefreshDatabase;

    public function testAuthenticatedUserCanUpdateContent()
    {
        $user = \App\Models\User::factory()->create([
            'email' => 'test@mail.com'
        ]);
        /** @var \Illuminate\Contracts\Auth\Authenticatable $user */
        $token = auth('api')->login($user);

        $content = \App\Models\Content::factory()->for($user)->create();

        $payload = [
            'content' => 'Updated content',
        ];

        $response = $this->withHeader('Authorization', "Bearer $token")
            ->putJson("/api/content/{$content->id}/update", $payload);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data' => [
                    'id' => $content->id,
                    'content' => 'Updated content',
                    'user_id' => $user->id,
                ]
            ]);

        $this->assertDatabaseHas('contents', [
            'id' => $content->id,
            'content' => 'Updated content',
        ]);
    }

    public function testUnauthorizedUserCannotUpdateContent()
    {
        $user = \App\Models\User::factory()->create([
            'email' => 'test@mail.com'
        ]);

        $content = \App\Models\Content::factory()->for($user)->create();

        $payload = [
            'content' => 'Updated content',
        ];

        $response = $this->putJson("/api/content/{$content->id}/update", $payload);

        $response->assertStatus(401);
    }
}
