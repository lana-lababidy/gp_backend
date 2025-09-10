<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
$user = $request->user();

        if (!$user || $user->role_id != 1) {
            return response()->json(['message' => 'Unauthorized: Admins only'], 403);
        }

        return $next($request);
    }
}
