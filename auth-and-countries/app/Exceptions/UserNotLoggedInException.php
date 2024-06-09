<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

class UserNotLoggedInException extends Exception
{
    protected $message = 'User not logged in!';
    protected $code = 400;

    public function render($request): JsonResponse
    {
        return response()->json([
            'message' => $this->getMessage()
        ], $this->getCode());
    }
}
