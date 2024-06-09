<?php

namespace app\Http\Requests;

use App\Rules\ValidReservationRule;
use Illuminate\Foundation\Http\FormRequest;

class ReservationRequest extends FormRequest
{
    const STORE_ROUTE = 'reservations.store';
    const UPDATE_ROUTE = 'reservations.update';

    const CLIENT_ID_KEY = 'client_id';
    const CHECK_IN_DATE_KEY = 'check_in_date';
    const CHECK_OUT_DATE_KEY = 'check_out_date';
    const HOTEL_ID_KEY = 'hotel_id';
    const ROOM_ID_KEY = 'room_id';
    const RESTAURANT_ID_KEY = 'restaurant_id';
    const TABLE_ID_KEY = 'table_id';
    const IS_PAID_KEY = 'is_paid';

    private static $rules = [
        self::STORE_ROUTE => [
            self::CLIENT_ID_KEY => [
                'required',
                'integer',
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
                'integer',
                'required_without_all:' . self::RESTAURANT_ID_KEY . ',' . self::TABLE_ID_KEY,
            ],
            self::ROOM_ID_KEY => [
                'integer',
                'required_without_all:' . self::RESTAURANT_ID_KEY . ',' . self::TABLE_ID_KEY,
            ],
            self::RESTAURANT_ID_KEY => [
                'integer',
                'required_without_all:' . self::HOTEL_ID_KEY . ',' . self::TABLE_ID_KEY,
            ],
            self::TABLE_ID_KEY => [
                'integer',
                'required_without_all:' . self::HOTEL_ID_KEY . ',' . self::ROOM_ID_KEY,
            ],
            self::IS_PAID_KEY => [
                'boolean',
                'required_with:' . self::HOTEL_ID_KEY . ',' . self::ROOM_ID_KEY,
            ]
        ],
        self::UPDATE_ROUTE => [
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

        if ($this->route()->getName() === self::STORE_ROUTE) {
            $rules[self::HOTEL_ID_KEY][] = new ValidReservationRule();
            $rules[self::ROOM_ID_KEY][] = new ValidReservationRule();
            $rules[self::RESTAURANT_ID_KEY][] = new ValidReservationRule();
            $rules[self::TABLE_ID_KEY][] = new ValidReservationRule();
        }

        return $rules;
    }
}
