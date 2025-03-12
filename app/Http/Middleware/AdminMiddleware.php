<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request; 
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::user() || !Auth::user()->hasRole('admin')) {
            // Redirect or abort if the user is not an admin
            return redirect('/')->with('error', 'Unauthorized access.');
        }

        return $next($request);
    }
}