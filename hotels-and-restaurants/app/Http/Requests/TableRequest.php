<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TableRequest extends FormRequest
{
    const STORE_ROUTE = 'restaurants.tables.store';
    const UPDATE_ROUTE = 'restaurants.tables.update';
    const NAME_KEY = 'name';
    const DESCRIPTION_KEY = 'description';
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
