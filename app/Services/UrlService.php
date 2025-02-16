<?php

namespace App\Services;

use Illuminate\Support\Str;

class UrlService
{
    public function shortenUrl()
    {
        return Str::random(6);
    }
}