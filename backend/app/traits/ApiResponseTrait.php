<?php

namespace App\Traits;

trait ApiResponseTrait
{
    public function success(int $code = 200, string $message, $data = null)
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data,
        ], $code);
    }
    public function error(int $code = 400, string $message, $error = null)
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'error' => $error,
        ], $code);
    }
}
