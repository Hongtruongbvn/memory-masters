<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $user = session('user');
        
        if (!$user || !$user['is_admin']) {
            return redirect()->route('dashboard')->withErrors(['access' => 'Access denied. Admin only.']);
        }

        return $next($request);
    }
}