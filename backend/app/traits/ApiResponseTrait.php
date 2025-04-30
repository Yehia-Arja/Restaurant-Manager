<?php

namespace App\Traits;

trait ApiResponseTrait
{
    public function success(string $message, $data = null, int $code = 200)
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data,
        ], $code);
    }
    public function error(string $message, $error = null, int $code = 400)
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'error' => $error,
        ], $code);
    }
}
