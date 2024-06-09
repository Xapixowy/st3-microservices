<?php

namespace app\Http\Resources;

use App\Services\ClientService;
use App\Services\HotelService;
use App\Services\RestaurantService;
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
            'client_id' => $this->client_id,
        ];

        if (isset($this->hotel_id) && is_numeric($this->room_id)) {
            $reservation['hotel_id'] = $this->hotel_id;
            $reservation['room_id'] = $this->room_id;
            $reservation['is_paid'] = $this->is_paid;
        } else if (isset($this->restaurant_id) && is_numeric($this->table_id)) {
            $reservation['restaurant_id'] = $this->restaurant_id;
            $reservation['table_id'] = $this->table_id;
        }

        try {
            $reservation['client'] = ClientService::downloadClient($this->client_id);
        } catch (\Exception $e) {
        }

        if ($this->hotel_id) {
            try {
                $reservation['hotel'] = HotelService::downloadHotel($this->hotel_id);
            } catch (\Exception $e) {
            }
        }

        if ($this->hotel_id && $this->room_id) {
            try {
                $reservation['room'] = HotelService::downloadRoom($this->hotel_id, $this->room_id);
            } catch (\Exception $e) {
            }
        }

        if ($this->restaurant_id) {
            try {
                $reservation['restaurant'] = RestaurantService::downloadRestaurant($this->restaurant_id);
            } catch (\Exception $e) {
            }
        }

        if ($this->restaurant_id && $this->table_id) {
            try {
                $reservation['table'] = RestaurantService::downloadTable($this->restaurant_id, $this->table_id);
            } catch (\Exception $e) {
            }
        }

        return $reservation;
    }
}
