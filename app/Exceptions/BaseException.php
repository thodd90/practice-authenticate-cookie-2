<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

class BaseException extends Exception
{
    protected int $httpStatusCode;

    public function __construct(string $message, int $httpStatusCode){
        $this->httpStatusCode = $httpStatusCode;
        parent::__construct($message);
    }

    public function render(): JsonResponse
    {
        return response()->json([
            'error' => true,
            'code' => $this->httpStatusCode,
            'message' => $this->message,
        ]);
    }
}
