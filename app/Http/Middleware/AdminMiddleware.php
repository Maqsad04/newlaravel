<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle($request, Closure $next)
    {
        // Check if the user is authenticated and is an admin
        if (Auth::check() && Auth::user()->role === 'admin') {
            return $next($request);
        }

        // Redirect non-admin users
        return redirect('/')->with('error', 'You do not have admin access.');
    }
}