<?php
namespace App\Modules\Exceptions;

use Throwable;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\JsonResponse;

class JWTExceptionHandler
{
    public static function handle(Throwable $exception): ?JsonResponse
    {
        if ($exception instanceof TokenExpiredException) {
            return response()->json(['error' => 'Token has expired'], 401);
        }

        if ($exception instanceof TokenInvalidException) {
            return response()->json(['error' => 'Token is invalid'], 401);
        }

        if ($exception instanceof JWTException) {
            return response()->json(['error' => 'Token not provided or malformed'], 401);
        }

        if ($exception instanceof AuthenticationException) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        return null;
    }
}
