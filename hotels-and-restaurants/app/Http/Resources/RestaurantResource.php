<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;

class RestaurantResource extends BusinessResource
{
    public function toArray(Request $request): array
    {
        $parentArray = parent::toArray($request);

        return array_merge($parentArray, [
            'tables' => TableResource::collection($this->tables)
        ]);
    }
}
