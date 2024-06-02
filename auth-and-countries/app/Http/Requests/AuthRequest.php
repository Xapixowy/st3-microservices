<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthRequest extends FormRequest
{
    const REGISTER_ROUTE = 'auth.register';
    const ACTIVATE_ROUTE = 'auth.activate';
    const LOGIN_ROUTE = 'auth.login';
    const AUTHENTICATE_ROUTE = 'auth.authenticate';
    const FIRST_NAME_KEY = 'first_name';
    const LAST_NAME_KEY = 'last_name';
    const EMAIL_KEY = 'email';
    const PHONE_KEY = 'phone';
    const PASSWORD_KEY = 'password';
    const VERIFICATION_CODE_KEY = 'verification_code';
    const TOKEN_KEY = 'token';

    private static $rules = [
        self::REGISTER_ROUTE => [
            self::FIRST_NAME_KEY => [
                'required',
                'string',
                'min:3',
                'max:100',
            ],
            self::LAST_NAME_KEY => [
                'required',
                'string',
                'min:3',
                'max:100',
            ],
            self::EMAIL_KEY => [
                'required',
                'email',
                'unique:users,email',
            ],
            self::PHONE_KEY => [
                'required',
                'string',
            ],
            self::PASSWORD_KEY => [
                'required',
                'string',
                'min:8',
                'max:100',
            ],
        ],
        self::ACTIVATE_ROUTE => [
            self::EMAIL_KEY => [
                'required',
                'email',
                'exists:users,email',
            ],
            self::VERIFICATION_CODE_KEY => [
                'required',
                'string',
                'size:6',
            ]
        ],
        self::LOGIN_ROUTE => [
            self::EMAIL_KEY => [
                'required',
                'email',
                'exists:users,email',
            ],
            self::PASSWORD_KEY => [
                'required',
                'string',
            ]
        ],
        self::AUTHENTICATE_ROUTE => [
            self::TOKEN_KEY => [
                'required',
                'string',
            ]
        ],
    ];

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = self::$rules[$this->route()->getName()];

        if ($this->route()->getName() === self::REGISTER_ROUTE) {
            $rules[self::PHONE_KEY][] = 'regex:' . config('regex.phone', '/\b\d{3}\d{3}-\d{3}\b/');
        }

        return $rules;
    }
}
