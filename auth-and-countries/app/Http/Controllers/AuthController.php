<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthRequest;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    private AuthService $service;

    public function __construct(AuthService $authService)
    {
        $this->service = $authService;
    }

    public function register(AuthRequest $request): JsonResponse
    {
        $params = $request->all();

        $registeredUser = $this->service->register($params);

        return response()->json([
            'message' => 'User registered',
            'verification_code' => $registeredUser['verification_code'],
        ], 201);
    }

    public function activate(AuthRequest $request): JsonResponse
    {
        $params = $request->all();

        $activationStatus = $this->service->activate($params);

        return response()->json([
            'message' => 'User activated',
        ]);
    }

    public function login(AuthRequest $request): JsonResponse
    {
        $params = $request->all();

        $token = $this->service->login($params['email'], $params['password']);

        return response()->json([
            'message' => 'User logged in',
            'token' => $token
        ]);
    }

    public function logout(Request $request): JsonResponse
    {
        $user = $request->user();

        $this->service->logout($user);

        return response()->json([
            'message' => 'User logged out',
        ]);
    }

    public function authenticate(AuthRequest $request): JsonResponse
    {
        $params = $request->only(['token']);

        $this->service->authenticate($params['token']);

        return response()->json([
            'message' => 'User authenticated',
        ]);
    }
}
