<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class HotelRequest extends FormRequest
{
    const STORE_ROUTE = 'hotels.store';
    const UPDATE_ROUTE = 'hotels.update';
    const ID_KEY = 'id';
    const NAME_KEY = 'name';
    const ADDRESS_KEY = 'address';
    const CITY_KEY = 'city';
    const STATE_KEY = 'state';
    const ZIP_KEY = 'zip';
    const COUNTRY_KEY = 'country';
    const PHONE_KEY = 'phone';
    const EMAIL_KEY = 'email';
    const IMAGE_KEY = 'image';

    private static $rules = [
        self::STORE_ROUTE => [
            self::NAME_KEY => [
                'required',
                'string',
                'min:3',
                'max:255',
            ],
            self::ADDRESS_KEY => [
                'required',
                'string',
                'min:3',
                'max:255',
            ],
            self::CITY_KEY => [
                'required',
                'string',
                'min:3',
                'max:255',
            ],
            self::STATE_KEY => [
                'required',
                'string',
                'min:3',
                'max:255',
            ],
            self::ZIP_KEY => [
                'required',
                'string',
                'min:6',
                'max:6',
            ],
            self::COUNTRY_KEY => [
                'required',
                'string',
                'min:3',
                'max:255',
            ],
            self::PHONE_KEY => [
                'required',
                'string',
                'min:11',
                'max:11',
            ],
            self::EMAIL_KEY => [
                'required',
                'email',
            ],
            self::IMAGE_KEY => [
                'required',
                'url',
            ],
        ],
        self::UPDATE_ROUTE => [
            self::NAME_KEY => [
                'string',
                'min:3',
                'max:255',
            ],
            self::ADDRESS_KEY => [
                'string',
                'min:3',
                'max:255',
            ],
            self::CITY_KEY => [
                'string',
                'min:3',
                'max:255',
            ],
            self::STATE_KEY => [
                'string',
                'min:3',
                'max:255',
            ],
            self::ZIP_KEY => [
                'string',
                'min:6',
                'max:6',
            ],
            self::COUNTRY_KEY => [
                'string',
                'min:3',
                'max:255',
            ],
            self::PHONE_KEY => [
                'string',
                'min:11',
                'max:11',
            ],
            self::EMAIL_KEY => [
                'email',
            ],
            self::IMAGE_KEY => [
                'url',
            ],
        ],
    ];

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = self::$rules[$this->route()->getName()];

        if (in_array($this->route()->getName(), [self::STORE_ROUTE, self::UPDATE_ROUTE])) {
            $rules[self::ZIP_KEY][] = 'regex:' . config('regex.zip', '/\b\d{2}-\d{3}\b/');
            $rules[self::PHONE_KEY][] = 'regex:' . config('regex.phone', '/\b\d{3}-\d{3}-\d{3}\b/');
        }

        return $rules;
    }
}
