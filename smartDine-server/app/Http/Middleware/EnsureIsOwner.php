<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureIsOwner
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user()->user_type_id !== 2) {
            return response()->json(['message' => 'Unauthorized. Owners only.'], 403);
        }

        return $next($request);
    }
}
