<?php

namespace App\Http\Middleware;

use App\Enum\Role;
use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Facades\JWTAuth;

class JWTMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (TokenExpiredException $e) {
            return response()->json(['error' => "Token telah kadarluasa"], 401);
        }
        catch (JWTException $e) {
            return response()->json(['error' => "Token tidak valid"], 401);
        }

        if (!$user) {
            return response()->json(['error' => 'User tidak ditemukan'], 401);
        }

        if ($user->role !== Role::Admin) {
            return response()->json(['error' => 'Akses Ditolak'], 403);
        }

        return $next($request);
    }
}
