<?php

namespace App\Models;

class TableReservation extends Reservation
{
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->fillable = array_merge($this->fillable, [
            'restaurant_id',
            'table_id',
        ]);
    }
}
