<?php

namespace app\Services;

use App\Exceptions\HotelNotFoundException;
use App\Http\Resources\BusinessResource;
use App\Http\Resources\RoomResource;
use App\Models\Business;
use App\Models\Room;
use Illuminate\Support\Facades\Http;

class HotelService
{
    const HOTEL_API_URL = 'http://hotels-and-restaurants/api/hotels';

    public static function downloadHotel(int $id): BusinessResource
    {
        try {
            $response = Http::timeout(5)->throw()->get(self::HOTEL_API_URL . '/' . $id);
        } catch (\Exception $e) {
            throw new HotelNotFoundException();
        }

        $responseData = $response->json()['data'];

        $address = $responseData['address']['street'] . ' ' . $responseData['address']['building_number'] . ', ' . $responseData['address']['zip_code'] . ' ' . $responseData['address']['city'] . ' ' . ($responseData['address']['country']['name'] ?? '');

        return BusinessResource::make(Business::make([
            'id' => $responseData['id'],
            'name' => $responseData['name'],
            'website' => $responseData['website'],
            'description' => $responseData['description'],
            'address' => $address,
            'phone' => $responseData['contact']['phone'],
            'email' => $responseData['contact']['email'],
        ]));
    }

    public static function downloadRoom(int $hotelId, int $roomId): RoomResource
    {
        try {
            $response = Http::timeout(5)->throw()->get(self::HOTEL_API_URL . '/' . $hotelId . '/rooms/' . $roomId);
        } catch (\Exception $e) {
            throw new HotelNotFoundException();
        }

        return RoomResource::make(Room::make($response->json()['data']));
    }
}
