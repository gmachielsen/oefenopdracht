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
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'content' => 'required|string',
            'image_url' => 'nullable|url',
            'is_published' => 'boolean',
            'published_at' => 'nullable|date',
        ]);

        if (!isset($validated['published_at']) && ($validated['is_published'] ?? true)) {
            $validated['published_at'] = now();
        }

        $news = News::create($validated);

        return response()->json([
            'success' => true,
            'data' => $news
        ], 201);
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

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $news = News::findOrFail($id);

        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
            'content' => 'sometimes|required|string',
            'image_url' => 'nullable|url',
            'is_published' => 'boolean',
            'published_at' => 'nullable|date',
        ]);

        $news->update($validated);

        return response()->json([
            'success' => true,
            'data' => $news
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $news = News::findOrFail($id);
        $news->delete();

        return response()->json([
            'success' => true,
            'message' => 'News deleted successfully'
        ]);
    }
}
