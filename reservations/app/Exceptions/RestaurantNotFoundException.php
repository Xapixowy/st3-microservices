<?php

namespace app\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

class RestaurantNotFoundException extends Exception
{
    protected $message = 'Restaurant not found!';
    protected $code = 404;

    public function render($request): JsonResponse
    {
        return response()->json([
            'message' => $this->getMessage()
        ], $this->getCode());
    }
}
