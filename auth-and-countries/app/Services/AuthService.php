<?php

namespace App\Services;

use App\Exceptions\UserAlreadyActivatedException;
use App\Exceptions\UserAlreadyLoggedInException;
use App\Exceptions\UserInvalidVerificationCodeException;
use App\Exceptions\UserNotActivatedException;
use App\Exceptions\UserNotLoggedInException;
use App\Exceptions\UserPasswordIncorrectException;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\PersonalAccessToken;

class AuthService
{
    public function register(array $data): UserResource
    {
        return DB::transaction(function () use ($data) {
            return UserResource::make(User::create([
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'phone' => $data['phone'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'verification_code' => rand(100000, 999999)
            ]));
        });
    }

    public function activate(array $data): UserResource
    {
        $user = User::where('email', $data['email'])
            ->first();

        if ($user->email_verified_at !== null) {
            throw new UserAlreadyActivatedException();
        }

        if ($user->verification_code !== $data['verification_code']) {
            throw new UserInvalidVerificationCodeException();
        }

        $user->verification_code = null;
        $user->email_verified_at = now();
        $user->save();

        return UserResource::make($user);
    }

    public function login(string $email, string $password): string
    {
        $user = User::where('email', $email)
            ->first();

        if ($user->tokens()->count() > 0) {
            throw new UserAlreadyLoggedInException();
        }

        if (!Hash::check($password, $user->password)) {
            throw new UserPasswordIncorrectException();
        }

        if ($user->email_verified_at === null) {
            throw new UserNotActivatedException();
        }

        return $user->createToken('authToken')->plainTextToken;
    }

    public function logout(User $user): bool
    {
        if ($user->tokens()->count() === 0) {
            throw new UserNotLoggedInException();
        }

        $user->tokens()->delete();

        return true;
    }

    public function authenticate(string $token): bool
    {
        if (!PersonalAccessToken::findToken($token)) {
            throw new UserNotLoggedInException();
        }

        return true;
    }
}
