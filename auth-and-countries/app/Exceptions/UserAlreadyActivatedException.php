<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

class UserAlreadyActivatedException extends Exception
{
    protected $message = 'User already activated!';
    protected $code = 400;

    public function render($request): JsonResponse
    {
        return response()->json([
            'message' => $this->getMessage()
        ], $this->getCode());
    }
}
