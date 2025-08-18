<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;


class loginAdmin extends Controller
{
    public function login(Request $request)
    {
        // 1. تجلب توكن الجلسة من هيدر الطلب
        $sessionToken = $request->header('Session-Token');

        // 2. تستدعي دالة checkRole لتتحقق من الجلسة والدور
        $role = checkRole($sessionToken,"Admin");

        // 3. إذا الجلسة غير صالحة ترجع رسالة خطأ 401
        if ($role === 'plz login to continue') {
            return response()->json(['message' => $role], 401);
        }



        // التحقق من المدخلات
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',

        ]);


        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        // تحقق كلمة المرور
        if (!Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Invalid password'], 401);
        }

        // تحقق إذا اليوزر هو admin (حسب role_id أو حسب نظامك)
        // مثلاً: role_id = 1 يعني admin
        if ($user->role_id != 1) {
            return response()->json(['message' => 'Unauthorized: Not admin'], 403);
        }

        // إنشاء جلسة جديدة (session) أو توكن حسب النظام عندك
        // افتراض: جلسة عادية في جدول sessions (علاقة hasMany)
//8
        $session = $user->sessions()->create([
            'session_token' => bin2hex(random_bytes(32)), // مثال توكن عشوائي
            'ip_address' => $request->ip(),
            'user_agent' => $request->header('User-Agent'),
            'last_activity' => now(),
        ]);

        return response()->json([
            'user' => $user,
            'session' => $session,
        ], 200);
    }
}
//         if ($validator->fails()) {
//             return response()->json(['error' => 'Invalid Parameters'], 401);
//         }

//         // البحث عن المستخدم بناءً على اسم المستخدم ورقم الهاتف
//         $user = User::where('username', $request->username)
//             ->where('email', $request->mobile_number)
//             ->first();

//         //  التحقق أولًا إذا كان المستخدم موجودًا قبل الوصول إلى role
//         if ($validator->fails()) {
//             return response()->json(['message' => 'Invalid username or mobile number'], 401);
//         }
//         // ✅ محاولة تسجيل الدخول باستخدام Auth
//         if (!Auth::attempt($request->only('email', 'password'))) {
//             return response()->json(['error' => 'Invalid email or password'], 401);
//         }
//         // ✅ المستخدم المسجل حاليًا
//         $user = Auth::user();

//         // //  تأكد من أن علاقة `role` موجودة في `User`:
//         if (!$user->role || $user->role->name !== 'admin') {
//             return response()->json(['error' => 'Unauthorized'], 403);
//         }


//         // إنشاء Access Token
//         // $token = $user->createToken('AdminAccessToken')->accessToken;
//         $token = $user->createToken('AdminAccessToken')->plainTextToken;

//         return response()->json([
//             'data' => $user,
//             'token' => $token
//         ]);
//     }
// }
