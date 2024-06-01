<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthRequest extends FormRequest
{
    const REGISTER_ROUTE = 'auth.register';
    const ACTIVATE_ROUTE = 'auth.activate';
    const LOGIN_ROUTE = 'auth.login';
    const AUTHENTICATE_ROUTE = 'auth.authenticate';
    const NAME_KEY = 'name';
    const EMAIL_KEY = 'email';
    const PASSWORD_KEY = 'password';
    const VERIFICATION_CODE_KEY = 'verification_code';
    const TOKEN_KEY = 'token';

    private static $rules = [
        self::REGISTER_ROUTE => [
            self::NAME_KEY => 'required|string',
            self::EMAIL_KEY => 'required|email|unique:users,email',
            self::PASSWORD_KEY => 'required|string|min:6',
        ],
        self::ACTIVATE_ROUTE => [
            self::EMAIL_KEY => 'required|email|exists:users,email',
            self::VERIFICATION_CODE_KEY => 'required|string',
        ],
        self::LOGIN_ROUTE => [
            self::EMAIL_KEY => 'required|email|exists:users,email',
            self::PASSWORD_KEY => 'required|string',
        ],
        self::AUTHENTICATE_ROUTE => [
            self::TOKEN_KEY => 'required|string',
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
