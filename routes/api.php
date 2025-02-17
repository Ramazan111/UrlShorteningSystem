<?php

use App\Http\Controllers\UrlController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/url-shortening', [UrlController::class, 'get']);
    Route::post('/url-shortening', [UrlController::class, 'store']);

    Route::get('/urls', [UrlController::class, 'index']);
    Route::post('/urls/{url}', [UrlController::class, 'update']);
});
