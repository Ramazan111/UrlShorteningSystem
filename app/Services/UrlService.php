<?php

namespace App\Services;

use App\Models\Url;
use Carbon\Carbon;
use Illuminate\Support\Str;

class UrlService
{
    private function shortenUrl()
    {
        return Str::random(6);
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
            $shortenUrl->expire_at = Carbon::now()->addMinutes(5);
            $shortenUrl->save();
        } else {
            $shortenUrl = Url::create([
                'original' => $payload->original,
                'expire_at' => Carbon::now()->addMinutes(5),
                'short_url' => $this->shortenUrl(),
                'clicks' => 0,
            ]);
        }

        return $shortenUrl;
    }
}