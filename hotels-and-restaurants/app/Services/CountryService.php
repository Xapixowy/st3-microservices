<?php

namespace App\Services;

use App\Exceptions\CountryNotFoundException;
use App\Http\Resources\CountryResource;
use App\Models\Country;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Http;

class CountryService
{
    const COUNTRY_API_URL = 'http://auth-and-countries/api/countries';

    public static function index(): AnonymousResourceCollection
    {
        return CountryResource::collection(Country::all());
    }

    public static function show(string $countryNumeric): CountryResource
    {
        $country = self::getCountry($countryNumeric);

        if (!$country->isComplete) {
            $country = self::update($countryNumeric);
        }

        return CountryResource::make($country);
    }

    private static function getCountry(string $countryNumeric): Country
    {
        $country = Country::where('numeric', $countryNumeric)->first();

        if (empty($country)) {
            $country = Country::create(['numeric' => $countryNumeric]);
        }

        return $country;
    }

    private static function update(string $countryNumeric): Country
    {
        $country = self::getCountry($countryNumeric);

        if (!$country->isComplete) {
            try {
                $completeCountry = self::downloadCountry($countryNumeric);
                $country->update($completeCountry->toArray());
            } catch (CountryNotFoundException $e) {
            }
        }

        return $country;
    }

    private static function downloadCountry(string $countryNumeric): Country
    {
        try {
            $response = Http::timeout(5)->throw()->get(self::COUNTRY_API_URL . '/find', ['numeric' => $countryNumeric]);
        } catch (\Exception $e) {
            throw new CountryNotFoundException();
        }

        if ($response->status() !== 200) {
            throw new CountryNotFoundException();
        }

        $country = Country::make($response->json()['data']);
        $country->isComplete = true;

        return $country;
    }

    public static function store(array $data): CountryResource
    {
        if (empty($data['isComplete'])) {
            try {
                $country = self::downloadCountry($data['numeric']);
            } catch (CountryNotFoundException $e) {
                $country = $data;
            }
        }

        return CountryResource::make(Country::create($country));
    }
}
