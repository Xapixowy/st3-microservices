<?php

namespace App\Http\Controllers;

use app\Http\Requests\ReservationRequest;
use app\Services\ReservationService;
use Illuminate\Http\JsonResponse;

class ReservationController extends Controller
{
    private ReservationService $service;

    public function __construct(ReservationService $reservationService)
    {
        $this->service = $reservationService;
    }

    public function index(): JsonResponse
    {
        $reservations = $this->service->index();

        return response()->json([
            'message' => 'Reservations retrieved',
            'data' => $reservations
        ]);
    }

    public function show(int $id): JsonResponse
    {
        $reservation = $this->service->show($id);

        return response()->json([
            'message' => 'Reservation retrieved',
            'data' => $reservation
        ]);
    }

    public function store(ReservationRequest $request): JsonResponse
    {
        $params = $request->all();

        $newReservation = $this->service->store($params);

        return response()->json([
            'message' => 'Reservation created',
            'data' => $newReservation
        ], 201);
    }

    public function update(ReservationRequest $request, int $id): JsonResponse
    {
        $params = $request->all();

        $updatedReservation = $this->service->update($id, $params);

        return response()->json([
            'message' => 'Reservation updated',
            'data' => $updatedReservation
        ]);
    }

    public function destroy(int $id): JsonResponse
    {
        $deletedReservation = $this->service->destroy($id);

        return response()->json([
            'message' => 'Reservation deleted',
            'data' => $deletedReservation
        ]);
    }
}
