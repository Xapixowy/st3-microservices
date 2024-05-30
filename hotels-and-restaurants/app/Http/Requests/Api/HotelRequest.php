<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class HotelRequest extends FormRequest
{
    const STORE_ROUTE = 'hotels.store';
    const UPDATE_ROUTE = 'hotels.update';
    const NAME_KEY = 'name';
    const ADDRESS_KEY = 'address';
    const CITY_KEY = 'city';
    const ZIP_KEY = 'zip_code';
    const COUNTRY_KEY = 'country_numeric';
    const PHONE_KEY = 'phone';
    const EMAIL_KEY = 'email';
    const WEBSITE_KEY = 'website';
    const DESCRIPTION_KEY = 'description';

    private static $rules = [
        self::STORE_ROUTE => [
            self::NAME_KEY => [
                'required',
                'string',
                'min:3',
                'max:100',
            ],
            self::ADDRESS_KEY => [
                'required',
                'string',
                'min:3',
                'max:100',
            ],
            self::CITY_KEY => [
                'required',
                'string',
                'min:3',
                'max:100',
            ],
            self::ZIP_KEY => [
                'required',
                'string',
            ],
            self::COUNTRY_KEY => [
                'required',
                'string',
            ],
            self::PHONE_KEY => [
                'required',
                'string',
            ],
            self::EMAIL_KEY => [
                'required',
                'email',
            ],
            self::WEBSITE_KEY => [
                'required',
                'url',
            ],
            self::DESCRIPTION_KEY => [
                'required',
                'string',
                'min:3',
                'max:255'
            ],
        ],
        self::UPDATE_ROUTE => [
            self::NAME_KEY => [
                'required',
                'string',
                'min:3',
                'max:100',
            ],
            self::ADDRESS_KEY => [
                'required',
                'string',
                'min:3',
                'max:100',
            ],
            self::CITY_KEY => [
                'required',
                'string',
                'min:3',
                'max:100',
            ],
            self::ZIP_KEY => [
                'required',
                'string',
            ],
            self::COUNTRY_KEY => [
                'required',
                'string',
            ],
            self::PHONE_KEY => [
                'required',
                'string',
            ],
            self::EMAIL_KEY => [
                'required',
                'email',
            ],
            self::WEBSITE_KEY => [
                'required',
                'url',
            ],
            self::DESCRIPTION_KEY => [
                'required',
                'string',
                'min:3',
                'max:255'
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
            $rules[self::PHONE_KEY][] = 'regex:' . config('regex.phone', '/\b\d{3}\d{3}-\d{3}\b/');
            $rules[self::COUNTRY_KEY][] = 'regex:' . config('regex.country_numeric', '/\b\d{3}\b/');
        }

        return $rules;
    }
}
