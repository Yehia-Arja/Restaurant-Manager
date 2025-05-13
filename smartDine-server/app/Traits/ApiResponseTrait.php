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
<<<<<<< HEAD
=======
    public function paginatedResponse(string $message, $data, $paginator, int $code = 200)
    {
        return response()->json([
            'success'   => true,
            'message'   => $message,
            'data'      => $data,
            'pagination' => [
                'current_page' => $paginator->currentPage(),
                'last_page'    => $paginator->lastPage(),
                'per_page'     => $paginator->perPage(),
                'total'        => $paginator->total(),
                'has_more'     => $paginator->hasMorePages(),
            ],
        ], $code);
    }
>>>>>>> 2b890721c062469001e41f7995fc9c4c496a783d
}
