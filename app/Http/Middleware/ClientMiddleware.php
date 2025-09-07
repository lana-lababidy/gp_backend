<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // تحقق من تسجيل الدخول
        if (!Auth::check()) {
            return response()->json(['message' => 'يجب تسجيل الدخول أولاً'], 401);
        }

        // تحقق أن المستخدم ليس أدمن
        if (Auth::user()->role_id !== 2) {
            return response()->json(['message' => 'ليس لديك صلاحية الوصول كمستخدم عادي'], 403);
        }

        return $next($request);
    }
}
