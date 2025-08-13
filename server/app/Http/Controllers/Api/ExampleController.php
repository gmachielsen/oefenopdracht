<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ExampleController extends Controller
{
    public function index()
    {
        return response()->json([
            'message' => 'Examples retrieved successfully!',
            'data' => [
                [
                    'id' => 1,
                    'name' => 'John Doe',
                    'email' => 'john@example.com',
                    'created_at' => now()
                ],
                [
                    'id' => 2,
                    'name' => 'Jane Smith',
                    'email' => 'jane@example.com',
                    'created_at' => now()
                ]
            ]
        ]);
    }

    public function show($id)
    {
        return response()->json([
            'message' => 'Example retrieved successfully!',
            'data' => [
                'id' => $id,
                'name' => 'John Doe',
                'email' => 'john@example.com',
                'created_at' => now()
            ]
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
        ]);

        return response()->json([
            'message' => 'Example created successfully!',
            'data' => array_merge($validated, [
                'id' => rand(100, 999),
                'created_at' => now()
            ])
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|email|max:255',
        ]);

        return response()->json([
            'message' => 'Example updated successfully!',
            'data' => array_merge($validated, [
                'id' => $id,
                'updated_at' => now()
            ])
        ]);
    }

    public function destroy($id)
    {
        return response()->json([
            'message' => 'Example deleted successfully!',
            'data' => ['id' => $id]
        ]);
    }
}
