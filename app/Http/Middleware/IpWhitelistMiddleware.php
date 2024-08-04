<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IpWhitelistMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    
    protected $whitelistedIps = [
        '127.0.0.1', // Replace with actual IPs
        '111.222.333.444',
    ];

    public function handle(Request $request, Closure $next)
    {
        if (!in_array($request->ip(), $this->whitelistedIps)) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        return $next($request);
    }
}
