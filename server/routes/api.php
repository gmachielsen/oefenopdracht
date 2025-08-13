<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ExampleController;
use App\Http\Controllers\Api\AuthController;

// Public authentication routes
Route::post('/login', [AuthController::class, 'login']);

// Protected authentication routes
Route::middleware('auth:api')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/me', [AuthController::class, 'me']);
});

// Simple test route
Route::get('/test', function () {
    return response()->json(['message' => 'API is working!']);
});

// Simple example routes without authentication
Route::get('/examples', [ExampleController::class, 'index']);
Route::post('/examples', [ExampleController::class, 'store']);
Route::get('/examples/{id}', [ExampleController::class, 'show']);
Route::put('/examples/{id}', [ExampleController::class, 'update']);
Route::delete('/examples/{id}', [ExampleController::class, 'destroy']);
