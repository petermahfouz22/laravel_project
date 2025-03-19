<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CandidateMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && auth()->user()->role === 'candidate') {
            return $next($request);
        }
        
        if (auth()->check()) {
            // User is logged in but not a candidate
            return redirect()->route('dashboard')
                ->with('error', 'You do not have candidate permissions.');
        }
        
        // User is not logged in
        return redirect()->route('login')
            ->with('error', 'Please login to access candidate features.');
    }
}