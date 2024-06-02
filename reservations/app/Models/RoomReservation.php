<?php

namespace App\Models;

class RoomReservation extends Reservation
{
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->fillable = array_merge($this->fillable, [
            'hotel_id',
            'room_id',
            'is_paid'
        ]);
    }
}
