<?php

namespace App\Services;

use App\Models\Url;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class UrlService
{
    private function shortenUrl()
    {
        return 'S/' . Str::random(6);
    }

    /**
     * Short url
     *
     * @param $payload
     * @return mixed
     */
    public function createShortUrl($payload)
    {
        $shortenUrl = Url::where('original', $payload->original)->first();

        if ($shortenUrl) {
            $shortenUrl->expire_at = Carbon::now(config('urlconfig.timezone'))->addMinutes(config('urlconfig.expiration_time'));
            $shortenUrl->save();
        } else {
            $shortenUrl = Url::create([
                'user_id' => Auth::guard('sanctum')->user()->id,
                'original' => $payload->original,
                'expire_at' => Carbon::now(config('urlconfig.timezone'))->addMinutes(config('urlconfig.expiration_time')),
                'short_url' => $this->shortenUrl(),
                'clicks' => 0,
            ]);
        }

        return $shortenUrl;
    }
}