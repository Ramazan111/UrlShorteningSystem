<?php

namespace Database\Factories;

use App\Models\Url;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UrlFactory extends Factory
{
    protected $model = Url::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'original' => $this->faker->url,
            'short_url' => 'S/' . Str::random(6),
            'expire_at' => Carbon::now(config('urlconfig.timezone'))->addMinutes(config('urlconfig.expiration_time')),
            'clicks' => 0,
        ];
    }
}
