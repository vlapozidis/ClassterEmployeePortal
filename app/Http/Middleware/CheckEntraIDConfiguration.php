<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckEntraIDConfiguration
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->routeIs('auth.microsoft', 'entra.callback')) {
            if (!config('services.microsoft.client_id') || !config('services.microsoft.client_secret')) {
                return view('auth.entra-not-configured');
            }
        }

        return $next($request);
    }
}
