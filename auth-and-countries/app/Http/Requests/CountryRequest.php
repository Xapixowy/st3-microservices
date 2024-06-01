<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CountryRequest extends FormRequest
{
    const FIND_ROUTE = 'countries.find';
    const ID_KEY = 'id';
    const NAME_KEY = 'name';
    const ALPHA2_KEY = 'alpha2';
    const ALPHA3_KEY = 'alpha3';
    const NUMERIC_KEY = 'numeric';
    const LICENSE_PLATE_KEY = 'license_plate';
    const DOMAIN_KEY = 'domain';

    private static $rules = [
        self::FIND_ROUTE => [
            self::ID_KEY => [
                'integer',
                'min:1'
            ],
            self::NAME_KEY => [
                'string',
                'min:3',
                'max:100'
            ],
            self::ALPHA2_KEY => [
                'string',
                'size:2'
            ],
            self::ALPHA3_KEY => [
                'string',
                'size:3'
            ],
            self::NUMERIC_KEY => [
                'string',
                'size:3'
            ],
            self::LICENSE_PLATE_KEY => [
                'string',
                'min:1',
                'max:3'
            ],
            self::DOMAIN_KEY => [
                'string',
                'min:1',
                'max:3'
            ]
        ]
    ];

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = self::$rules[$this->route()->getName()];

        if ($this->route()->getName() === self::FIND_ROUTE) {
            $fields = array_keys($rules);

            foreach ($fields as $field) {
                $rules[$field][] = 'required_without_all:' . implode(',', array_diff($fields, [$field]));
            }
        }

        return $rules;
    }
}
