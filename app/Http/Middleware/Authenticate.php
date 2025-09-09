<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Auth\Middleware\Authenticate as Middleware; // مهم جداً

class Authenticate extends Middleware
{
    protected function redirectTo($request)
    {
        // لو الطلب API (JSON)، ما نرجع رابط
        if ($request->expectsJson()) {
            return null;
        }

        // لو طلب ويب عادي، ممكن ترجع رابط login
        return route('login'); // تأكد إنك عامل route باسم login
    }

    protected function unauthenticated($request, array $guards)
    {
        if ($request->expectsJson()) {
            abort(response()->json(['message' => 'Unauthenticated.'], 401));
        }

        // نستدعي الدالة الأصلية لو مش API
        parent::unauthenticated($request, $guards);
    }
}
