<?php

namespace App\Http\Controllers;

use App\Http\Requests\HotelRequest;
use App\Services\HotelService;
use Illuminate\Http\JsonResponse;

class HotelController extends Controller
{
    private HotelService $service;

    public function __construct(HotelService $hotelService)
    {
        $this->service = $hotelService;
    }

    public function index(): JsonResponse
    {
        $hotels = $this->service->index();

        return response()->json([
            'message' => 'Hotels retrieved',
            'data' => $hotels
        ]);
    }

    public function show(int $id): JsonResponse
    {
        $hotel = $this->service->show($id);

        return response()->json([
            'message' => 'Hotel retrieved',
            'data' => $hotel
        ]);
    }

    public function store(HotelRequest $request): JsonResponse
    {
        $params = $request->all();

        $newHotel = $this->service->store($params);

        return response()->json([
            'message' => 'Hotel created',
            'data' => $newHotel
        ], 201);
    }

    public function update(HotelRequest $request, int $id): JsonResponse
    {
        $params = $request->all();

        $updatedHotel = $this->service->update($id, $params);

        return response()->json([
            'message' => 'Hotel updated',
            'data' => $updatedHotel
        ]);
    }

    public function destroy(int $id): JsonResponse
    {
        $deletedHotel = $this->service->destroy($id);

        return response()->json([
            'message' => 'Hotel deleted',
            'data' => $deletedHotel
        ]);
    }
}
