<?php

namespace App\Services;

use App\Exceptions\HotelNotFoundException;
use App\Exceptions\RoomNotFoundException;
use App\Http\Resources\RoomResource;
use App\Models\Hotel;
use App\Models\Room;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\DB;

class RoomService
{
    public function index(int $hotelId): AnonymousResourceCollection
    {
        $hotel = $this->getHotel($hotelId);

        return RoomResource::collection($hotel->rooms);
    }

    private function getHotel(int $hotelId): Hotel
    {
        $hotel = Hotel::find($hotelId);

        if (empty($hotel)) {
            throw new HotelNotFoundException();
        }

        return $hotel;
    }

    public function show(int $hotelId, int $id): RoomResource
    {
        $hotel = $this->getHotel($hotelId);

        $room = $this->getRoom($hotel, $id);

        return RoomResource::make($room);
    }

    private function getRoom(Hotel $hotel, int $roomId): Room
    {
        $room = $hotel->rooms->find($roomId);

        if (empty($room)) {
            throw new RoomNotFoundException();
        }

        return $room;
    }

    public function store(int $hotelId, array $data): RoomResource
    {
        $hotel = $this->getHotel($hotelId);

        return DB::transaction(function () use ($hotel, $data) {
            return RoomResource::make($hotel->rooms()->create($data));
        });
    }

    public function update(int $hotelId, int $id, array $data): RoomResource
    {
        $hotel = $this->getHotel($hotelId);

        $room = $this->getRoom($hotel, $id);

        return DB::transaction(function () use ($room, $data) {
            $room->update($data);

            return RoomResource::make($room);
        });
    }

    public function destroy(int $hotelId, int $id): RoomResource
    {
        $hotel = $this->getHotel($hotelId);

        $room = $this->getRoom($hotel, $id);

        return DB::transaction(function () use ($id, $room) {
            $room->delete();

            return RoomResource::make($room);
        });
    }
}
