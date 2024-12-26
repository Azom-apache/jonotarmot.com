<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AttachUser
{
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            Log::info('User is authenticated: ' . Auth::user()->name);
            view()->share('user', Auth::user());
        } else {
            Log::info('User is not authenticated.');
        }

        return $next($request);
    }
}