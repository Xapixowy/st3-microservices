<?php

namespace App\Services;

use App\Exceptions\CountryNotFoundException;
use App\Http\Resources\CountryResource;
use App\Models\Country;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CountryService
{
    public function index(): AnonymousResourceCollection
    {
        return CountryResource::collection(Country::all());
    }

    public function find(array $params): CountryResource
    {
        $key = array_key_first($params);
        $value = $params[$key];

        $country = Country::where($key, $value)->first();

        if (!$country) {
            throw new CountryNotFoundException();
        }

        return new CountryResource($country);
    }
}
