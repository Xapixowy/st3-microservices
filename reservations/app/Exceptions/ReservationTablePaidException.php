<?php

namespace app\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

class ReservationTablePaidException extends Exception
{
    protected $message = 'Table reservations cannot be paid!';
    protected $code = 409;

    public function render($request): JsonResponse
    {
        return response()->json([
            'message' => $this->getMessage()
        ], $this->getCode());
    }
}
