<?php

namespace App\Http\Controllers;

use App\Http\Requests\RestaurantRequest;
use App\Services\RestaurantService;
use Illuminate\Http\JsonResponse;

class RestaurantController extends Controller
{
    private RestaurantService $service;

    public function __construct(RestaurantService $restaurantService)
    {
        $this->service = $restaurantService;
    }

    public function index(): JsonResponse
    {
        $restaurants = $this->service->index();

        return response()->json([
            'message' => 'Restaurants retrieved',
            'data' => $restaurants
        ]);
    }

    public function show(int $id): JsonResponse
    {
        $restaurant = $this->service->show($id);

        return response()->json([
            'message' => 'Restaurant retrieved',
            'data' => $restaurant
        ]);
    }

    public function store(RestaurantRequest $request): JsonResponse
    {
        $params = $request->all();

        $newRestaurant = $this->service->store($params);

        return response()->json([
            'message' => 'Restaurant created',
            'data' => $newRestaurant
        ], 201);
    }

    public function update(RestaurantRequest $request, int $id): JsonResponse
    {
        $params = $request->all();

        $updatedRestaurant = $this->service->update($id, $params);

        return response()->json([
            'message' => 'Restaurant updated',
            'data' => $updatedRestaurant
        ]);
    }

    public function destroy(int $id): JsonResponse
    {
        $deletedRestaurant = $this->service->destroy($id);

        return response()->json([
            'message' => 'Restaurant deleted',
            'data' => $deletedRestaurant
        ]);
    }
}
