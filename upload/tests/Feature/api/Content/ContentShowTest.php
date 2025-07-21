<?php

namespace Tests\Feature\api\Content;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContentShowTest extends TestCase
{
    use RefreshDatabase;

    public function testAuthenticatedUserCanViewContent()
    {
        $user = \App\Models\User::factory()->create([
            'email' => 'test@mail.com',
        ]);
        /** @var \Illuminate\Contracts\Auth\Authenticatable $user */
        $token = auth('api')->login($user);

        $content = \App\Models\Content::factory()->for($user)->create();

        $response = $this->withHeader('Authorization', "Bearer $token")
            ->getJson("/api/content/{$content->id}");

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data' => [
                    'id' => $content->id,
                    'content' => $content->content,
                    'user_id' => $user->id,
                ],
            ]);
    }

    public function testUnauthorizedUserCannotViewContent()
    {
        $user = \App\Models\User::factory()->create([
            'email' => 'test@mail.com',
        ]);

        $content = \App\Models\Content::factory()->for($user)->create();

        $response = $this->getJson("/api/content/{$content->id}");

        $response->assertStatus(401);
    }
}
