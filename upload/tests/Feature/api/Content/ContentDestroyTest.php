<?php

namespace Tests\Feature\api\Content;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContentDestroyTest extends TestCase
{
    use RefreshDatabase;

    public function testAuthenticatedUserCanDeleteContent()
    {
        $user = \App\Models\User::factory()->create([
            'email' => 'test@mail.com'
        ]);
        /** @var \Illuminate\Contracts\Auth\Authenticatable $user */
        $token = auth('api')->login($user);

        $content = \App\Models\Content::factory()->for($user)->create();

        $response = $this->withHeader('Authorization', "Bearer $token")
            ->deleteJson("/api/content/{$content->id}/delete");

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'The content was deleted.'
            ]);

        $this->assertDatabaseMissing('contents', [
            'id' => $content->id,
        ]);
    }

    public function testUnauthorizedUserCannotDeleteContent()
    {
        $user = \App\Models\User::factory()->create([
            'email' => 'test@mail.com'
        ]);

        $content = \App\Models\Content::factory()->for($user)->create();

        $response = $this->deleteJson("/api/content/{$content->id}/delete");

        $response->assertStatus(401);
    }
}
