<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoomRequest;
use App\Services\RoomService;
use Illuminate\Http\JsonResponse;

class RoomController extends Controller
{
    private RoomService $service;

    public function __construct(RoomService $roomService)
    {
        $this->service = $roomService;
    }

    public function index(int $hotelId): JsonResponse
    {
        $rooms = $this->service->index($hotelId);

        return response()->json([
            'message' => 'Rooms retrieved',
            'data' => $rooms
        ]);
    }

    public function show(int $hotelId, int $id): JsonResponse
    {
        $room = $this->service->show($hotelId, $id);

        return response()->json([
            'message' => 'Room retrieved',
            'data' => $room
        ]);
    }

    public function store(int $hotelId, RoomRequest $request): JsonResponse
    {
        $params = $request->all();

        $newRoom = $this->service->store($hotelId, $params);

        return response()->json([
            'message' => 'Room created',
            'data' => $newRoom
        ], 201);
    }

    public function update(int $hotelId, RoomRequest $request, int $id): JsonResponse
    {
        $params = $request->all();

        $updatedRoom = $this->service->update($hotelId, $id, $params);

        return response()->json([
            'message' => 'Room updated',
            'data' => $updatedRoom
        ]);
    }

    public function destroy(int $hotelId, int $id): JsonResponse
    {
        $deletedRoom = $this->service->destroy($hotelId, $id);

        return response()->json([
            'message' => 'Room deleted',
            'data' => $deletedRoom
        ]);
    }
}
