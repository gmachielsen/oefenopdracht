<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $news = News::where('is_published', true)
            ->orderBy('published_at', 'desc')
            ->orderBy('created_at', 'desc')
            ->get(['id', 'title', 'description', 'image_url', 'published_at', 'created_at']);

        return response()->json([
            'success' => true,
            'data' => $news
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $news = News::where('is_published', true)->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $news
        ]);
    }
}
