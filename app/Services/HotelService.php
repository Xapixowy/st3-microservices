<?php

use App\Models\Hotel;
use Illuminate\Support\Facades\DB;

class HotelService {
    public function index(): array
    {
        return Hotel::all()->toArray();
    }

    public function show(int $id): array
    {
        return Hotel::find($id)->toArray();
    }

    public function store(array $data): array
    {
        return DB::transaction(function () use ($data) {
            return Hotel::create($data)->toArray();
        });
    }

    public function update(int $id, array $data): array
    {
        return DB::transaction(function () use ($id, $data) {
            $hotel = Hotel::find($id);
            $hotel->update($data);

            return $hotel->toArray();
        });
    }

    public function destroy(int $id): array
    {
        $hotel = Hotel::find($id);

        DB::transaction(function () use ($id) {
            Hotel::destroy($id);
        });

        return $hotel->toArray();
    }
}
