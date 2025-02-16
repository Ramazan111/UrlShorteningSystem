<?php

use App\Http\Controllers\UrlController;
use Illuminate\Support\Facades\Route;

Route::get('/url-shortening', [UrlController::class, 'get']);
Route::post('/url-shortening', [UrlController::class, 'store']);
