<?php

namespace Tests\Unit;

use App\Models\Url;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Carbon\Carbon;

class UrlControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function clicking_a_short_url_increments_the_click_count()
    {
        $user = User::factory()->create();
        $url = Url::factory()->create([
            'user_id' => $user->id,
            'short_url' => 'S/abc123',
            'clicks' => 0,
            'expire_at' => Carbon::now()->addMinutes(10),
        ]);

        $response = $this->get('/S/abc123');

        $url->refresh();

        $this->assertEquals(1, $url->clicks);
        $response->assertRedirect($url->original);
    }

    /** @test */
    public function it_creates_a_new_short_url()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $payload = [
            'original' => 'https://example.com',
        ];

        $response = $this->post('/api/url-shortening', $payload);

        $response->assertStatus(201);
        $this->assertDatabaseHas('urls', [
            'original' => 'https://example.com',
            'user_id' => $user->id,
        ]);
    }

    /** @test */
    public function it_updates_the_expiration_date_of_a_short_url()
    {
        $user = User::factory()->create();
        $url = Url::factory()->create([
            'user_id' => $user->id,
            'expire_at' => Carbon::now()->addMinutes(10),
        ]);

        $this->actingAs($user);

        $payload = [
            'expire_at' => Carbon::now()->addMinutes(20)->toDateTimeString(),
        ];

        $response = $this->post("/api/urls/{$url->id}", $payload);

        $url->refresh();

        $response->assertStatus(201);
        $this->assertEquals($payload['expire_at'], $url->expire_at);
    }

    /** @test */
    public function it_returns_a_list_of_urls_for_the_authenticated_user()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        Url::factory()->count(5)->create([
            'user_id' => $user->id,
        ]);

        $response = $this->getJson('/api/urls');

        $response->assertStatus(200);
        $response->assertJsonCount(5, 'data');
    }
}
