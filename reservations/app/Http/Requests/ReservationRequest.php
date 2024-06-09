<?php

namespace app\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReservationRequest extends FormRequest
{
    const STORE_ROUTE = 'reservations.store';
    const UPDATE_ROUTE = 'reservations.update';

    const CLIENT_FIRST_NAME_KEY = 'client_first_name';
    const CLIENT_LAST_NAME_KEY = 'client_last_name';
    const CLIENT_EMAIL_KEY = 'client_email';
    const CLIENT_PHONE_KEY = 'client_phone';
    const CHECK_IN_DATE_KEY = 'check_in_date';
    const CHECK_OUT_DATE_KEY = 'check_out_date';
    const HOTEL_ID_KEY = 'hotel_id';
    const ROOM_ID_KEY = 'room_id';
    const RESTAURANT_ID_KEY = 'restaurant_id';
    const TABLE_ID_KEY = 'table_id';
    const IS_PAID_KEY = 'is_paid';

    private static $rules = [
        self::STORE_ROUTE => [
            self::CLIENT_FIRST_NAME_KEY => [
                'required',
                'string',
                'min:3',
                'max:100',
            ],
            self::CLIENT_LAST_NAME_KEY => [
                'required',
                'string',
                'min:3',
                'max:100',
            ],
            self::CLIENT_EMAIL_KEY => [
                'required',
                'email',
            ],
            self::CLIENT_PHONE_KEY => [
                'required',
                'string',
            ],
            self::CHECK_IN_DATE_KEY => [
                'required',
                'date',
            ],
            self::CHECK_OUT_DATE_KEY => [
                'required',
                'date',
            ],
            self::HOTEL_ID_KEY => [
                'required',
                'integer',
            ],
            self::ROOM_ID_KEY => [
                'required',
                'integer',
            ],
            self::RESTAURANT_ID_KEY => [
                'required',
                'integer',
            ],
            self::TABLE_ID_KEY => [
                'required',
                'integer',
            ],
            self::IS_PAID_KEY => [
                'boolean',
            ]
        ],
        self::UPDATE_ROUTE => [
            self::CLIENT_FIRST_NAME_KEY => [
                'string',
                'min:3',
                'max:100',
            ],
            self::CLIENT_LAST_NAME_KEY => [
                'string',
                'min:3',
                'max:100',
            ],
            self::CLIENT_EMAIL_KEY => [
                'email',
            ],
            self::CLIENT_PHONE_KEY => [
                'string',
            ],
            self::CHECK_IN_DATE_KEY => [
                'date',
            ],
            self::CHECK_OUT_DATE_KEY => [
                'date',
            ],
            self::HOTEL_ID_KEY => [
                'integer',
            ],
            self::ROOM_ID_KEY => [
                'integer',
            ],
            self::RESTAURANT_ID_KEY => [
                'integer',
            ],
            self::TABLE_ID_KEY => [
                'integer',
            ],
            self::IS_PAID_KEY => [
                'boolean',
            ],
        ]
    ];

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = self::$rules[$this->route()->getName()];

        if (in_array($this->route()->getName(), [self::STORE_ROUTE, self::UPDATE_ROUTE])) {
            $rules[self::HOTEL_ID_KEY][] = 'required_without_all:' . self::RESTAURANT_ID_KEY . ',' . self::TABLE_ID_KEY;
            $rules[self::ROOM_ID_KEY][] = 'required_without_all:' . self::RESTAURANT_ID_KEY . ',' . self::TABLE_ID_KEY;
            $rules[self::IS_PAID_KEY][] = 'required_without_all:' . self::RESTAURANT_ID_KEY . ',' . self::TABLE_ID_KEY;
            $rules[self::RESTAURANT_ID_KEY][] = 'required_without_all:' . self::HOTEL_ID_KEY . ',' . self::TABLE_ID_KEY;
            $rules[self::TABLE_ID_KEY][] = 'required_without_all:' . self::HOTEL_ID_KEY . ',' . self::ROOM_ID_KEY;
            $rules[self::CLIENT_PHONE_KEY][] = 'regex:' . config('regex.phone', '/\b\d{3}\d{3}-\d{3}\b/');
        }

        return self::$rules[$this->route()->getName()];
    }
}
