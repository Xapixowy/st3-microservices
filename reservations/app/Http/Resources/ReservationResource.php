<?php

namespace app\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReservationResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $reservation = [
            'id' => $this->id,
            'check_in_date' => $this->check_in_date,
            'check_out_date' => $this->check_out_date,
            'client' => $this->client,
        ];

        if (isset($this->hotel_id) && is_numeric($this->room_id)) {
            $reservation['hotel_id'] = $this->hotel_id;
            $reservation['room_id'] = $this->room_id;
            $reservation['is_paid'] = $this->is_paid;
        } else if (isset($this->restaurant_id) && is_numeric($this->table_id)) {
            $reservation['restaurant_id'] = $this->restaurant_id;
            $reservation['table_id'] = $this->table_id;
        }

        return $reservation;
    }
}
