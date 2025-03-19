<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && auth()->user()->role === 'admin') {
            return $next($request);
        }
        
        if (auth()->check()) {
            // User is logged in but not an admin
            return redirect()->route('dashboard')
                ->with('error', 'You do not have admin permissions.');
        }
        
        // User is not logged in
        return redirect()->route('login')
            ->with('error', 'Please login to access admin features.');
    }
}