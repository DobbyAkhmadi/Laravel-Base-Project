<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class Authenticate extends Middleware
{
    protected function unauthenticated($request, array $guards): JsonResponse
    {
        abort(response()->json(
            ['status' => Response::HTTP_UNAUTHORIZED,
                'message' => 'Unauthenticated.', ], 401));
    }
}
