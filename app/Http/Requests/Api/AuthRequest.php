<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class AuthRequest extends FormRequest
{
    private static $rules = [
        'auth.register' => [
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
        ],
        'auth.activate' => [
            'email' => 'required|email|exists:users,email',
            'verification_code' => 'required|string',
        ],
        'auth.login' => [
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string',
        ],
        'auth.logout' => [],
        'auth.authenticate' => [
            'token' => 'required|string',
        ],
    ];

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return self::$rules[$this->route()->getName()];
    }
}
