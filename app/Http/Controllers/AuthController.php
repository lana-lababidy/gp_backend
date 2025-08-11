<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

use App\Models\User;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{
    public function login(Request $request)
    {
        // تحقق من صحة المدخلات
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // محاولة تسجيل الدخول
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json(['error' => 'بيانات الدخول غير صحيحة'], 401);
        }

        // جلب المستخدم بعد نجاح تسجيل الدخول
        $user = Auth::user();

        // إنشاء توكن جديد
        // $token = $user->createToken('API Token')->plainTextToken;

        // إرجاع التوكن والمستخدم
        return response()->json([
            // 'token' => $token,
            'user' => $user,
        ]);
    }
}