<?php

namespace app\Services;

use App\Exceptions\ReservationNotFoundException;
use App\Exceptions\ReservationOverlappingException;
use App\Exceptions\ReservationTablePaidException;
use App\Http\Requests\ReservationRequest;
use App\Http\Resources\ReservationResource;
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
        $this->checkIfReservationOverlapping(
            $data[ReservationRequest::CHECK_IN_DATE_KEY],
            $data[ReservationRequest::CHECK_OUT_DATE_KEY],
            $data[ReservationRequest::ROOM_ID_KEY] ?? null,
            $data[ReservationRequest::TABLE_ID_KEY] ?? null
        );

        return DB::transaction(function () use ($data) {
            return ReservationResource::make(Reservation::create($data));
        });
    }

    private function checkIfReservationOverlapping(string $check_in_date, string $check_out_date, ?int $room_id, ?int $table_id): void
    {
        $reservations = Reservation::where(function ($query) use ($check_in_date, $check_out_date) {
            $query->where(ReservationRequest::CHECK_IN_DATE_KEY, '<', $check_out_date)
                ->where(ReservationRequest::CHECK_OUT_DATE_KEY, '>', $check_in_date);
        })->where(function ($query) use ($room_id, $table_id) {
            if ($room_id) {
                $query->where(ReservationRequest::ROOM_ID_KEY, $room_id);
            }
            if ($table_id) {
                $query->where(ReservationRequest::TABLE_ID_KEY, $table_id);
            }
        })->get();

        if (!$reservations->isEmpty()) {
            throw new ReservationOverlappingException();
        }
    }

    public function update(int $id, array $data): ReservationResource
    {
        $reservation = $this->getReservation($id);

        if ($reservation->restaurant_id || $reservation->table_id) {
            throw new ReservationTablePaidException();
        };

        return DB::transaction(function () use ($reservation, $data) {
            $reservation->update($data);

            return ReservationResource::make($reservation);
        });
    }

    public function destroy(int $id): ReservationResource
    {
        $reservation = $this->getReservation($id);

        return DB::transaction(function () use ($id, $reservation) {
            Reservation::destroy($id);

            return ReservationResource::make($reservation);
        });
    }
}
