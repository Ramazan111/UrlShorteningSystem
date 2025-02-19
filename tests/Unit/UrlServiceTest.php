<?php

namespace Tests\Unit;

use App\Models\Url;
use App\Models\User;
use App\Services\UrlService;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class UrlServiceTest extends TestCase
{
    use RefreshDatabase;

    protected $urlService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->urlService = new UrlService();
    }

    /** @test */
    public function it_creates_a_new_short_url()
    {
        $user = User::factory()->create();
        Auth::login($user);

        $payload = (object) [
            'original' => 'https://example.com'
        ];

        $expire_at_time = Carbon::now(config('urlconfig.timezone'))->addMinutes(config('urlconfig.expiration_time'))->format('d/m/y h:m:s');

        $shortUrl = $this->urlService->createShortUrl($payload);

        $this->assertInstanceOf(Url::class, $shortUrl); // check if returns same instance
        $this->assertEquals($payload->original, $shortUrl->original); // check if payload is equal to response
        $this->assertEquals($user->id, $shortUrl->user_id); // check user ids
        $this->assertNotNull($shortUrl->short_url); // short url must not be null
        $this->assertEquals(0, $shortUrl->clicks); // clicks should be 0
        $this->assertNotNull($shortUrl->expire_at);
        $this->assertEquals($expire_at_time, $shortUrl->expire_at->format('d/m/y h:m:s'));
        $this->assertTrue(Carbon::parse($shortUrl->expire_at)->isAfter(Carbon::now(config('urlconfig.timezone'))));
    }

    /** @test */
    public function it_updates_expiration_of_existing_short_url()
    {
        $user = User::factory()->create();
        Auth::login($user);

        $existingUrl = Url::factory()->create([
            'user_id' => $user->id,
            'original' => 'https://example.com',
            'clicks' => 3,
            'expire_at' => Carbon::now(config('urlconfig.timezone'))->subMinute(),
        ]);

        $payload = (object) [
            'original' => 'https://example.com'
        ];

        $updatedUrl = $this->urlService->createShortUrl($payload);

        $this->assertEquals($existingUrl->id, $updatedUrl->id);
        $this->assertEquals($existingUrl->clicks, $updatedUrl->clicks);
        $this->assertTrue(Carbon::parse($updatedUrl->expire_at)->isAfter(Carbon::now(config('urlconfig.timezone'))));
    }
}
