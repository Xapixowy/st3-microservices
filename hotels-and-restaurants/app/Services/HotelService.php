<?php

namespace App\Services;

use App\Exceptions\HotelNotFoundException;
use App\Http\Resources\HotelResource;
use App\Models\Hotel;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\DB;

class HotelService
{
    public function index(): AnonymousResourceCollection
    {
        return HotelResource::collection(Hotel::all());
    }

    public function show(int $id): HotelResource
    {
        return HotelResource::make($this->getHotel($id));
    }

    private function getHotel(int $hotelId): Hotel
    {
        $hotel = Hotel::find($hotelId);

        if (empty($hotel)) {
            throw new HotelNotFoundException();
        }

        return $hotel;
    }

    public function store(array $data): HotelResource
    {
        $hotelData = [
            'name' => $data['name'],
            'website' => $data['website'],
            'description' => $data['description']
        ];

        $addressData = [
            'street' => $data['street'],
            'building_number' => $data['building_number'],
            'city' => $data['city'],
            'zip_code' => $data['zip_code'],
            'country_numeric' => $data['country_numeric']
        ];

        $contactData = [
            'phone' => $data['phone'],
            'email' => $data['email']
        ];

        return DB::transaction(function () use ($hotelData, $addressData, $contactData) {
            $newHotel = Hotel::create($hotelData);
            $newHotel->address()->create($addressData);
            $newHotel->contact()->create($contactData);

            return HotelResource::make($newHotel);
        });
    }

    public function update(int $id, array $data): HotelResource
    {
        $hotel = $this->getHotel($id);

        $hotelData = array_filter([
            'name' => $data['name'] ?? null,
            'website' => $data['website'] ?? null,
            'description' => $data['description'] ?? null
        ], fn($value) => $value !== null);

        $addressData = array_filter([
            'street' => $data['street'] ?? null,
            'building_number' => $data['building_number'] ?? null,
            'city' => $data['city'] ?? null,
            'zip_code' => $data['zip_code'] ?? null,
            'country_numeric' => $data['country_numeric'] ?? null
        ], fn($value) => $value !== null);

        $contactData = array_filter([
            'phone' => $data['phone'] ?? null,
            'email' => $data['email'] ?? null
        ], fn($value) => $value !== null);

        return DB::transaction(function () use ($hotel, $hotelData, $addressData, $contactData) {
            $hotel->update($hotelData);
            $hotel->address()->update($addressData);
            $hotel->contact()->update($contactData);

            return HotelResource::make($hotel);
        });
    }

    public function destroy(int $id): HotelResource
    {
        $hotel = $this->getHotel($id);

        return DB::transaction(function () use ($id, $hotel) {
            Hotel::destroy($id);

            return HotelResource::make($hotel);
        });
    }
}
