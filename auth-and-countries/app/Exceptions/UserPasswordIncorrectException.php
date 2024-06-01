<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

class UserPasswordIncorrectException extends Exception
{
    protected $message = 'Password incorrect';
    protected $code = 400;

    public function render($request): JsonResponse
    {
        return response()->json([
            'message' => $this->getMessage()
        ], $this->getCode());
    }
}
