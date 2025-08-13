<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\NewsController;

// Public news routes
Route::get('/', [NewsController::class, 'index']);
Route::get('/{id}', [NewsController::class, 'show']);

// Protected news routes (for admin functionality)
Route::middleware('auth:api')->group(function () {
    Route::post('/', [NewsController::class, 'store']);
    Route::put('/{id}', [NewsController::class, 'update']);
    Route::delete('/{id}', [NewsController::class, 'destroy']);
});
