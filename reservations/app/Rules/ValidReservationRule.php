<?php

namespace App\Rules;

use app\Http\Requests\ReservationRequest;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidReservationRule implements ValidationRule
{
    private bool $isHotelProvided;
    private bool $isRoomProvided;
    private bool $isRestaurantProvided;
    private bool $isTableProvided;

    public function __construct()
    {
        $this->isHotelProvided = request()->has(ReservationRequest::HOTEL_ID_KEY);
        $this->isRoomProvided = request()->has(ReservationRequest::ROOM_ID_KEY);
        $this->isRestaurantProvided = request()->has(ReservationRequest::RESTAURANT_ID_KEY);
        $this->isTableProvided = request()->has(ReservationRequest::TABLE_ID_KEY);
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ($attribute === ReservationRequest::HOTEL_ID_KEY) {
            if ($this->isRestaurantProvided) {
                $fail(ReservationRequest::HOTEL_ID_KEY . ' and ' . ReservationRequest::RESTAURANT_ID_KEY . ' cannot be provided at the same time.');
            }
            if ($this->isTableProvided) {
                $fail(ReservationRequest::HOTEL_ID_KEY . ' and ' . ReservationRequest::TABLE_ID_KEY . ' cannot be provided at the same time.');
            }
        }

        if ($attribute === ReservationRequest::RESTAURANT_ID_KEY) {
            if ($this->isHotelProvided) {
                $fail(ReservationRequest::RESTAURANT_ID_KEY . ' and ' . ReservationRequest::HOTEL_ID_KEY . ' cannot be provided at the same time.');
            }
            if ($this->isRoomProvided) {
                $fail(ReservationRequest::RESTAURANT_ID_KEY . ' and ' . ReservationRequest::ROOM_ID_KEY . ' cannot be provided at the same time.');
            }
        }

        if ($attribute === ReservationRequest::ROOM_ID_KEY) {
            if ($this->isRestaurantProvided) {
                $fail(ReservationRequest::ROOM_ID_KEY . ' and ' . ReservationRequest::RESTAURANT_ID_KEY . ' cannot be provided at the same time.');
            }
            if ($this->isTableProvided) {
                $fail(ReservationRequest::ROOM_ID_KEY . ' and ' . ReservationRequest::TABLE_ID_KEY . ' cannot be provided at the same time.');
            }
        }

        if ($attribute === ReservationRequest::TABLE_ID_KEY) {
            if ($this->isHotelProvided) {
                $fail(ReservationRequest::TABLE_ID_KEY . ' and ' . ReservationRequest::HOTEL_ID_KEY . ' cannot be provided at the same time.');
            }
            if ($this->isRoomProvided) {
                $fail(ReservationRequest::TABLE_ID_KEY . ' and ' . ReservationRequest::ROOM_ID_KEY . ' cannot be provided at the same time.');
            }
        }
    }
}
