<?php

use App\Console\Commands\deleteExpiredUrls;
use App\Models\Url;
use Carbon\Carbon;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::call(function () {
    Url::where('expire_at', '<', Carbon::now(config('urlconfig.timezone')))->delete();
})->everyMinute();
