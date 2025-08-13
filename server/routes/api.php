<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Simple test route
Route::get('/test', function () {
    return response()->json(['message' => 'API is working!']);
});

// Include modular route files
Route::prefix('auth')->group(base_path('routes/api/auth.php'));
Route::prefix('news')->group(base_path('routes/api/news.php'));
