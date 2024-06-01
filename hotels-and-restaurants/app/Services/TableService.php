<?php

namespace App\Services;

use App\Exceptions\RestaurantNotFoundException;
use App\Exceptions\TableNotFoundException;
use App\Http\Resources\RoomResource;
use App\Http\Resources\TableResource;
use App\Models\Restaurant;
use App\Models\Room;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\DB;

class TableService
{
    public function index(int $restaurantId): AnonymousResourceCollection
    {
        $restaurant = $this->getRestaurant($restaurantId);

        return RoomResource::collection($restaurant->tables);
    }

    private function getRestaurant(int $restaurantId): Restaurant
    {
        $restaurant = Restaurant::find($restaurantId);

        if (empty($restaurant)) {
            throw new RestaurantNotFoundException();
        }

        return $restaurant;
    }

    public function show(int $restaurantId, int $id): TableResource
    {
        $restaurant = $this->getRestaurant($restaurantId);

        $table = $this->getTable($restaurant, $id);

        return TableResource::make($table);
    }

    private function getTable(Restaurant $restaurant, int $tableId): Room
    {
        $table = $restaurant->tables->find($tableId);

        if (empty($table)) {
            throw new TableNotFoundException();
        }

        return $table;
    }

    public function store(int $restaurantId, array $data): TableResource
    {
        $restaurant = $this->getRestaurant($restaurantId);

        return DB::transaction(function () use ($restaurant, $data) {
            return TableResource::make($restaurant->tables()->create($data));
        });
    }

    public function update(int $restaurantId, int $id, array $data): TableResource
    {
        $restaurant = $this->getRestaurant($restaurantId);

        $table = $this->getTable($restaurant, $id);

        return DB::transaction(function () use ($table, $data) {
            $table->update($data);

            return TableResource::make($table);
        });
    }

    public function destroy(int $restaurantId, int $id): TableResource
    {
        $restaurant = $this->getRestaurant($restaurantId);

        $table = $this->getTable($restaurant, $id);

        return DB::transaction(function () use ($id, $table) {
            $table->delete();

            return TableResource::make($table);
        });
    }
}
