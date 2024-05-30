<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\HotelRequest;
use HotelService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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

        return response()->json($hotels, 204);
    }

    public function show(int $id): JsonResponse
    {
        $hotel = $this->service->show($id);

        return response()->json($hotel);
    }

    public function store(HotelRequest $request): JsonResponse
    {
        $params = $request->all();

        $newHotel = $this->service->store($params);

        return response()->json($newHotel,201);
    }

    public function update(HotelRequest $request, int $id): JsonResponse
    {
        $params = $request->all();

        $updatedHotel = $this->service->update($id, $params);

        return response()->json($updatedHotel);
    }

    public function destroy(int $id): JsonResponse
    {
        $deletedHotel = $this->service->destroy($id);

        return response()->json($deletedHotel);
    }
}
