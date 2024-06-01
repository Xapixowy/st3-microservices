<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HotelRequest extends FormRequest
{
    const STORE_ROUTE = 'hotels.store';
    const UPDATE_ROUTE = 'hotels.update';
    const NAME_KEY = 'name';
    const WEBSITE_KEY = 'website';
    const DESCRIPTION_KEY = 'description';
    const STREET_KEY = 'street';
    const BUILDING_NUMBER_KEY = 'building_number';
    const CITY_KEY = 'city';
    const ZIP_KEY = 'zip_code';
    const COUNTRY_KEY = 'country_numeric';
    const PHONE_KEY = 'phone';
    const EMAIL_KEY = 'email';

    private static $rules = [
        self::STORE_ROUTE => [
            self::NAME_KEY => [
                'required',
                'string',
                'min:3',
                'max:100',
            ],
            self::WEBSITE_KEY => [
                'url',
            ],
            self::DESCRIPTION_KEY => [
                'required',
                'string',
                'min:3',
                'max:255'
            ],
            self::STREET_KEY => [
                'required',
                'string',
                'min:3',
                'max:100',
            ],
            self::BUILDING_NUMBER_KEY => [
                'required',
                'string',
                'min:1',
                'max:10',
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
        ],
        self::UPDATE_ROUTE => [
            self::NAME_KEY => [
                'string',
                'min:3',
                'max:100',
            ],
            self::WEBSITE_KEY => [
                'url',
            ],
            self::DESCRIPTION_KEY => [
                'string',
                'min:3',
                'max:255'
            ],
            self::STREET_KEY => [
                'string',
                'min:3',
                'max:100',
            ],
            self::BUILDING_NUMBER_KEY => [
                'string',
                'min:1',
                'max:10',
            ],
            self::CITY_KEY => [
                'string',
                'min:3',
                'max:100',
            ],
            self::ZIP_KEY => [
                'string',
            ],
            self::COUNTRY_KEY => [
                'string',
            ],
            self::PHONE_KEY => [
                'string',
            ],
            self::EMAIL_KEY => [
                'email',
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
