<?php

namespace App\Services;

use App\Exceptions\RestaurantNotFoundException;
use App\Http\Resources\RestaurantResource;
use App\Models\Restaurant;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\DB;

class RestaurantService
{
    public function index(): AnonymousResourceCollection
    {
        return RestaurantResource::collection(Restaurant::all());
    }

    public function show(int $id): RestaurantResource
    {
        return RestaurantResource::make($this->getRestaurant($id));
    }

    private function getRestaurant(int $restaurantId): Restaurant
    {
        $restaurant = Restaurant::find($restaurantId);

        if (empty($restaurant)) {
            throw new RestaurantNotFoundException();
        }

        return $restaurant;
    }

    public function store(array $data): RestaurantResource
    {
        $restaurantData = [
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

        return DB::transaction(function () use ($restaurantData, $addressData, $contactData) {
            $newRestaurant = Restaurant::create($restaurantData);
            $newRestaurant->address()->create($addressData);
            $newRestaurant->contact()->create($contactData);

            return RestaurantResource::make($newRestaurant);
        });
    }

    public function update(int $id, array $data): RestaurantResource
    {
        $restaurant = $this->getRestaurant($id);

        $restaurantData = array_filter([
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

        return DB::transaction(function () use ($restaurant, $restaurantData, $addressData, $contactData) {
            $restaurant->update($restaurantData);
            $restaurant->address()->update($addressData);
            $restaurant->contact()->update($contactData);

            return RestaurantResource::make($restaurant);
        });
    }

    public function destroy(int $id): RestaurantResource
    {
        $restaurant = $this->getRestaurant($id);

        return DB::transaction(function () use ($id, $restaurant) {
            Restaurant::destroy($id);

            return RestaurantResource::make($restaurant);
        });
    }
}
