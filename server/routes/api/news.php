<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\NewsController;

// Public news routes with rate limiting
Route::middleware('throttle:60,1')->group(function () {
    Route::get('/', [NewsController::class, 'index']);
    Route::get('/{id}', [NewsController::class, 'show']);
});
