<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

class TableNotFoundException extends Exception
{
    protected $message = 'Table not found!';
    protected $code = 404;

    public function render($request): JsonResponse
    {
        return response()->json([
            'message' => $this->getMessage()
        ], $this->getCode());
    }
}
