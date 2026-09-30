<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AuthMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!session('user')) {
            return redirect()->route('login')->withErrors(['email' => 'Please login first.']);
        }
        
        view()->share('currentUser', session('user'));
        
        return $next($request);
    }
}