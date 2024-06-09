<?php

namespace app\Services;

use App\Exceptions\HotelNotFoundException;
use App\Http\Resources\BusinessResource;
use App\Http\Resources\TableResource;
use App\Models\Business;
use App\Models\Table;
use Illuminate\Support\Facades\Http;

class RestaurantService
{
    const RESTAURANT_API_URL = 'http://hotels-and-restaurants/api/restaurants';

    public static function downloadRestaurant(int $id): BusinessResource
    {
        try {
            $response = Http::timeout(5)->throw()->get(self::RESTAURANT_API_URL . '/' . $id);
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

    public static function downloadTable(int $tableId, int $roomId): TableResource
    {
        try {
            $response = Http::timeout(5)->throw()->get(self::RESTAURANT_API_URL . '/' . $tableId . '/tables/' . $roomId);
        } catch (\Exception $e) {
            throw new HotelNotFoundException();
        }

        return TableResource::make(Table::make($response->json()['data']));
    }
}
