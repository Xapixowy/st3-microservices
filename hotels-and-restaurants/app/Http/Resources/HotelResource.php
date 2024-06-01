<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;

class HotelResource extends BusinessResource
{
    public function toArray(Request $request): array
    {
        $parentArray = parent::toArray($request);

        return array_merge($parentArray, [
            'rooms' => RoomResource::collection($this->rooms)
        ]);
    }
}
