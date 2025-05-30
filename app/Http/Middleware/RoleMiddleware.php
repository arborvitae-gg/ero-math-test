<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Middleware to restrict access based on user role.
 *
 * @package App\Http\Middleware
 */
class RoleMiddleware
{
    /**
     * Handle an incoming request and check user role.
     *
     * @param Request $request
     * @param \Closure $next
     * @param string $role
     * @return Response
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // Use Laravel's policy for role check (correct argument order)
        if (auth()->check() && $request->user()->can('hasRole', $role)) {
            return $next($request);
        }
        abort(403, 'Unauthorized.');
    }
}
