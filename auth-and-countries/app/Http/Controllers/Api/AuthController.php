<?php

namespace App\Http\Controllers\Api;

use App\Enums\UserActivationStatus;
use App\Enums\UserLoginStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\AuthRequest;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    private AuthService $service;

    public function __construct(AuthService $authService)
    {
        $this->service = $authService;
    }

    public function register(AuthRequest $request): JsonResponse
    {
        $params = $request->only(['name', 'email', 'password']);

        $registeredUser = $this->service->register($params['name'], $params['email'], $params['password']);
        Log::info('User registered', $registeredUser);

        return response()->json([
            'message' => 'User registered',
            'verification_code' => $registeredUser['verification_code'],
        ], 201);
    }

    public function activate(AuthRequest $request): JsonResponse
    {
        $params = $request->only(['email', 'verification_code']);

        $activationStatus = $this->service->activate($params['email'], $params['verification_code']);

        if ($activationStatus === UserActivationStatus::ALREADY_ACTIVATED) {
            Log::info('User already activated', ['email' => $params['email']]);

            return response()->json([
                'message' => 'User already activated',
            ], 400);
        }

        if ($activationStatus === UserActivationStatus::NOT_ACTIVATED) {
            Log::info('User not activated', ['email' => $params['email']]);

            return response()->json([
                'message' => 'User not activated. Invalid verification code.',
            ], 400);
        }

        Log::info('User activated', ['email' => $params['email']]);

        return response()->json([
            'message' => 'User activated',
        ]);
    }

    public function login(AuthRequest $request): JsonResponse
    {
        $params = $request->only(['email', 'password']);

        $loginStatus = $this->service->login($params['email'], $params['password']);

        if ($loginStatus === UserLoginStatus::ALREADY_LOGGED_IN) {
            Log::info('User already logged in', ['email' => $params['email']]);

            return response()->json([
                'message' => 'User already logged in',
            ], 400);
        }

        if ($loginStatus === UserLoginStatus::PASSWORD_INCORRECT) {
            Log::info('Password incorrect', ['email' => $params['email']]);

            return response()->json([
                'message' => 'Password incorrect',
            ], 400);
        }

        if ($loginStatus === UserLoginStatus::ACCOUNT_NOT_ACTIVATED) {
            Log::info('Account not activated', ['email' => $params['email']]);

            return response()->json([
                'message' => 'Account not activated',
            ], 400);
        }

        Log::info('User logged in', ['email' => $params['email']]);

        return response()->json([
            'message' => 'User logged in',
            'token' => $loginStatus,
        ]);
    }

    public function logout(AuthRequest $request): JsonResponse
    {
        $user = $request->user();

        $logoutStatus = $this->service->logout($user);

        if ($logoutStatus === UserLoginStatus::NOT_LOGGED_IN) {
            Log::info('User not logged in', ['email' => $user->email]);

            return response()->json([
                'message' => 'User not logged in',
            ], 400);
        }

        Log::info('User logged out', ['email' => $user->email]);

        return response()->json([
            'message' => 'User logged out',
        ]);
    }

    public function authenticate(AuthRequest $request): JsonResponse
    {
        $params = $request->only(['token']);

        $authenticateStatus = $this->service->authenticate($params['token']);

        if ($authenticateStatus === UserLoginStatus::NOT_LOGGED_IN) {
            Log::info('User not logged in', ['token' => $params['token']]);

            return response()->json([
                'message' => 'User not logged in',
            ], 400);
        }

        Log::info('User authenticated', ['token' => $params['token']]);

        return response()->json([
            'message' => 'User authenticated',
        ]);
    }
}
