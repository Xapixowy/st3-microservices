<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    private UserService $service;

    public function __construct(UserService $userService)
    {
        $this->service = $userService;
    }

    public function find(int $id): JsonResponse
    {
        $user = $this->service->find($id);

        return response()->json([
            'message' => 'User retrieved',
            'data' => $user
        ]);
    }
}
