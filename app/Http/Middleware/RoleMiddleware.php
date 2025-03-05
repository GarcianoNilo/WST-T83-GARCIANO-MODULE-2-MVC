<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $role
     * @return mixed
     */
    public function handle(Request $request, Closure $next, string $role = null)
    {
        // If user is not logged in, redirect to login page
        if (!Auth::check()) {
            return redirect('login');
        }

        // If role is specified, check if user has that role
        if ($role !== null && Auth::user()->role !== $role) {
            abort(403, 'You don\'t have permission to access this resource.');
        }

        return $next($request);
    }
}