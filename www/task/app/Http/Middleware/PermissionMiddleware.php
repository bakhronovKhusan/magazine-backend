<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class PermissionMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        // Проверяем, есть ли у пользователя роль "админа"
        if ($user && $user->hasRole('admin')) {
            return $next($request);
        }
        return response()->json(['message' => 'Access denied!'], 403);
    }
}
