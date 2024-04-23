<?php

namespace App\Services;

use App\Enums\UserActivationStatus;
use App\Enums\UserLoginStatus;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\PersonalAccessToken;

class AuthService
{
    public function register(string $name, string $email, string $password): array
    {
        return DB::transaction(function () use ($name, $email, $password) {
            return User::create([
                'name' => $name,
                'email' => $email,
                'password' => Hash::make($password),
                'verification_code' => rand(100000, 999999)
            ])->toArray();
        });
    }

    public function activate(string $email, string $verificationCode): UserActivationStatus
    {
        $user = User::where('email', $email)
            ->first();

        if ($user->email_verified_at !== null) {
            return UserActivationStatus::ALREADY_ACTIVATED;
        }

        if ($user->verification_code !== $verificationCode) {
            return UserActivationStatus::NOT_ACTIVATED;
        }

        $user->verification_code = null;
        $user->email_verified_at = now();
        $user->save();

        return UserActivationStatus::ACTIVATED;
    }

    public function login(string $email, string $password): UserLoginStatus|string
    {
        $user = User::where('email', $email)
            ->first();

        if ($user->tokens()->count() > 0) {
            return UserLoginStatus::ALREADY_LOGGED_IN;
        }

        if (!Hash::check($password, $user->password)) {
            return UserLoginStatus::PASSWORD_INCORRECT;
        }

        if ($user->email_verified_at === null) {
            return UserLoginStatus::ACCOUNT_NOT_ACTIVATED;
        }

        return $user->createToken('authToken')->plainTextToken;
    }

    public function logout(User $user): UserLoginStatus
    {
        if ($user->tokens()->count() === 0) {
            return UserLoginStatus::NOT_LOGGED_IN;
        }

        $user->tokens()->delete();

        return UserLoginStatus::LOGGED_OUT;
    }

    public function authenticate(string $token): UserLoginStatus
    {
        if (!PersonalAccessToken::findToken($token)) {
            return UserLoginStatus::NOT_LOGGED_IN;
        }

        return UserLoginStatus::ALREADY_LOGGED_IN;
    }
}
