<?php

namespace App\Http\Controllers;

use App\Http\Requests\CountryRequest;
use App\Services\CountryService;
use Illuminate\Http\JsonResponse;

class CountryController extends Controller
{
    private CountryService $service;

    public function __construct(CountryService $countryService)
    {
        $this->service = $countryService;
    }

    public function index(): JsonResponse
    {
        $countries = $this->service->index();

        return response()->json([
            'message' => 'Countries retrieved',
            'data' => $countries
        ]);
    }

    public function find(CountryRequest $request): JsonResponse
    {
        $params = $request->all();

        $country = $this->service->find($params);

        return response()->json([
            'message' => 'Country retrieved',
            'data' => $country
        ]);
    }
}
