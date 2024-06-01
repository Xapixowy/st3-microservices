<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoomRequest extends FormRequest
{
    const STORE_ROUTE = 'hotels.rooms.store';
    const UPDATE_ROUTE = 'hotels.rooms.update';
    const NAME_KEY = 'name';
    const DESCRIPTION_KEY = 'description';
    const PRICE_KEY = 'price';
    const CAPACITY_KEY = 'capacity';

    private static $rules = [
        self::STORE_ROUTE => [
            self::NAME_KEY => [
                'required',
                'string',
                'min:3',
                'max:100',
            ],
            self::DESCRIPTION_KEY => [
                'required',
                'string',
                'min:3',
                'max:255'
            ],
            self::PRICE_KEY => [
                'required',
                'numeric',
                'min:0',
            ],
            self::CAPACITY_KEY => [
                'required',
                'integer',
                'min:1',
            ],
        ],
        self::UPDATE_ROUTE => [
            self::NAME_KEY => [
                'string',
                'min:3',
                'max:100',
            ],
            self::DESCRIPTION_KEY => [
                'string',
                'min:3',
                'max:255'
            ],
            self::PRICE_KEY => [
                'numeric',
                'min:0',
            ],
            self::CAPACITY_KEY => [
                'integer',
                'min:1',
            ],
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
