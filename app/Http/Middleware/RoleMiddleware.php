<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role=null): Response
    {
        if (Auth::check() && in_array($role, [Auth::user()->role, 'admin'])) {
            return $next($request);
        }

        // User doesn't have the required role (or not logged in)
        return response()->json([
            'message' => 'You don\'t have permission to access this resource.',
        ], 401); // Unauthorized status code
    }
}
