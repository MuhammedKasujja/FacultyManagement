<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Support\Facades\Log;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;
use Tymon\JWTAuth\Facades\JWTAuth;

class JwtMiddleware extends BaseMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        try {
            $user =  JWTAuth::parseToken()->authenticate();
        } catch (Exception $e) {
            Log::error('AuthError ' . $e->getMessage());
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
                return response()->json(['error' => 'Token is Invalid', 'success' => false, 'error_code' => 403]);
            } else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
                return response()->json(['error' => 'Token is Expired', 'success' => false, 'error_code' => 403]);
            } else {
                return response()->json(['error' => 'Authorization Token not found', 'success' => false, 'error_code' => 403]);
            }
        }
        return $next($request);
    }
}
