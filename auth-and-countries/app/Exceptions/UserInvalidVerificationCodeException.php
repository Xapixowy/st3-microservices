<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

class UserInvalidVerificationCodeException extends Exception
{
    protected $message = 'User not activated. Invalid verification code';
    protected $code = 400;

    public function render($request): JsonResponse
    {
        return response()->json([
            'message' => $this->getMessage()
        ], $this->getCode());
    }
}
