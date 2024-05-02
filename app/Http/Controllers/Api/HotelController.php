<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class HotelController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json([
            'message' => 'Hotels retrieved',
        ]);
    }

    public function show(int $id): JsonResponse
    {
        return response()->json([
            'message' => 'Hotel retrieved',
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        return response()->json([
            'message' => 'Hotel created',
        ], 201);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        return response()->json([
            'message' => 'Hotel updated',
        ]);
    }

    public function destroy(int $id): JsonResponse
    {
        return response()->json([
            'message' => 'Hotel deleted',
        ]);
    }
}
