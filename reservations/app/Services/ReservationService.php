<?php

namespace app\Services;

use app\Exceptions\ReservationNotFoundException;
use app\Exceptions\ReservationOverlappingException;
use app\Http\Resources\ReservationResource;
use App\Models\Reservation;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\DB;

class ReservationService
{
    public function index(): AnonymousResourceCollection
    {
        return ReservationResource::collection(Reservation::all());
    }

    public function show(int $id): ReservationResource
    {
        return ReservationResource::make($this->getReservation($id));
    }

    private function getReservation(int $reservationId): Reservation
    {
        $reservation = Reservation::find($reservationId);

        if (empty($reservation)) {
            throw new ReservationNotFoundException();
        }

        return $reservation;
    }

    public function store(array $data): ReservationResource
    {
        $this->checkIfReservationOverlapping($data['check_in_date'], $data['check_out_date']);

        $userData = [
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
        ];

        $reservationData = [
            'check_in_date' => $data['check_in_date'],
            'check_out_date' => $data['check_out_date'],
            'hotel_id' => $data['hotel_id'],
            'room_id' => $data['room_id'],
            'restaurant_id' => $data['restaurant_id'],
            'table_id' => $data['table_id'],
            'is_paid' => $data['is_paid']
        ];


        return DB::transaction(function () use ($userData, $reservationData) {
            $newReservation = Reservation::create($reservationData);
            $newReservation->user()->create($userData);

            return ReservationResource::make($newReservation);
        });
    }

    private function checkIfReservationOverlapping(string $check_in_date, string $check_out_date): void
    {
        $reservations = Reservation::where('check_in_date', '<=', $check_in_date)
            ->where('check_out_date', '>=', $check_out_date)
            ->get();

        if (!empty($reservations)) {
            throw new ReservationOverlappingException();
        }
    }

    public function update(int $id, array $data): ReservationResource
    {
        if (isset($data['check_in_date']) || isset($data['check_out_date'])) {
            $this->checkIfReservationOverlapping($data['check_in_date'], $data['check_out_date']);
        }

        $reservation = $this->getReservation($id);

        $clientData = array_filter([
            'first_name' => $data['first_name'] ?? null,
            'last_name' => $data['last_name'] ?? null,
            'email' => $data['email'] ?? null,
            'phone' => $data['phone'] ?? null,
        ], fn($value) => $value !== null);

        $reservationData = array_filter([
            'check_in_date' => $data['check_in_date'] ?? null,
            'check_out_date' => $data['check_out_date'] ?? null,
            'hotel_id' => $data['hotel_id'] ?? null,
            'room_id' => $data['room_id'] ?? null,
            'restaurant_id' => $data['restaurant_id'] ?? null,
            'table_id' => $data['table_id'] ?? null,
            'is_paid' => $data['is_paid'] ?? null
        ], fn($value) => $value !== null);

        return DB::transaction(function () use ($reservation, $clientData, $reservationData) {
            $reservation->update($reservationData);
            $reservation->client()->update($clientData);

            return ReservationResource::make($reservation);
        });
    }

    public function destroy(int $id): ReservationResource
    {
        $reservation = $this->getReservation($id);

        return DB::transaction(function () use ($id, $reservation) {
            Reservation::destroy($id);
            $reservation->user()->delete();
            return ReservationResource::make($reservation);
        });
    }
}
