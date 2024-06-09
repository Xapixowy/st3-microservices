<?php

namespace app\Services;

use App\Exceptions\ClientNotFoundException;
use App\Http\Resources\ClientResource;
use App\Models\Client;
use Illuminate\Support\Facades\Http;

class ClientService
{
    const USER_API_URL = 'http://auth-and-countries/api/users';

    public static function downloadClient(int $id): ClientResource
    {
        try {
            $response = Http::timeout(5)->throw()->get(self::USER_API_URL . '/find/' . $id);
        } catch (\Exception $e) {
            throw new ClientNotFoundException();
        }

        return ClientResource::make(Client::make($response->json()['data']));
    }
}
