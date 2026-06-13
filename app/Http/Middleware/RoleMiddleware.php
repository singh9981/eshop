<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $roles)
    {
        $rolesArray = explode('|', $roles); // string → array

        if (!auth()->check() || !in_array(auth()->user()->role, $rolesArray)) {
            abort(403, 'Unauthorized');
        }

        return $next($request);
    }
}