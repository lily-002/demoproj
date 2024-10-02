<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Spatie\Permission\Models\Role;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next, ...$rolesOrPermissions)
    {
        $exemptedRoutes = [
            'login',
            'register',
            // Add other exempted routes as needed
        ];

        // Check if the current route is exempted
        if (in_array($request->route()->getName(), $exemptedRoutes)) {
            return $next($request);
        }

        // Check for roles or permissions
        if ($request->user() && $request->user()->hasAnyRole($rolesOrPermissions)) {
            return $next($request);
        }

        return response()->json([
            'message' => 'Unauthorized',
        ], Response::HTTP_UNAUTHORIZED);
    }

}
