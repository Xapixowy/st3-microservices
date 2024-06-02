<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AddressResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'street' => $this->street,
            'building_number' => $this->building_number,
            'city' => $this->city,
            'zip_code' => $this->zip_code,
            'country' => $this->country,
        ];
    }
}

