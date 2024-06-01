<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

class UserAlreadyLoggedInException extends Exception
{
    protected $message = 'User already logged in';
    protected $code = 400;

    public function render($request): JsonResponse
    {
        return response()->json([
            'message' => $this->getMessage()
        ], $this->getCode());
    }
}
