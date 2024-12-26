<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle($request, Closure $next, ...$roles)
    {
        // Auth::logout();
        if (!Auth::check()) {
            return redirect('/login');
        }
        
        $role = Auth::user()->role;

        
        if (!in_array($role, $roles)) {
            return abort(403);
        }

        return $next($request);
    }
}
