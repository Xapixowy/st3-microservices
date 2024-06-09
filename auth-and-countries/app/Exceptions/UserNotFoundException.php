<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

class UserNotFoundException extends Exception
{
    protected $message = 'User not found!';
    protected $code = 404;

    public function render($request): JsonResponse
    {
        return response()->json([
            'message' => $this->getMessage()
        ], $this->getCode());
    }
}
