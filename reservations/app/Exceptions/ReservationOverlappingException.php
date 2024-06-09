<?php

namespace app\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

class ReservationOverlappingException extends Exception
{
    protected $message = 'Reservation overlapping!';
    protected $code = 409;

    public function render($request): JsonResponse
    {
        return response()->json([
            'message' => $this->getMessage()
        ], $this->getCode());
    }
}
