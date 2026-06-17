<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string $role): mixed
    {
        if (!auth()->check() || auth()->user()->role !== $role) {
            abort(403, 'Access Denied. You do not have permission.');
        }
        return $next($request);
    }
}
