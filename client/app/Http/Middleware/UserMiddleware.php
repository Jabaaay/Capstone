<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check() || auth()->user()->is_admin) {
            return redirect()->route('admin.dashboard')->with('error', 'Unauthorized access.');
        }

        return $next($request);
    }
} 