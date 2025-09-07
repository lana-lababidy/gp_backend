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

        // التحقق من المدخلات
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255|',
            'password' => 'required|string|min:6',

        ]);
        if ($validator->fails()) {
            return response()->json(['error' => 'Invalid Parameters'], 422);
        }


        $user = User::where('email', $request->email)->first();
        // إذا المستخدم غير موجود، أنشئه
        if (!$user) {
            $user = User::create([
                'email' => $request->email,
                'password' => Hash::make($request->password), // تشفير الباسورد
                'role_id' => 1, // اجعلها admin إذا تريد إنشاء ادمن جديد
                'name' => 'Admin', // أو أي قيمة افتراضية للاسم
                'mobile_number' => null,

            ]);
        } else {
            // تحقق كلمة المرور فقط إذا المستخدم موجود
            if (!Hash::check($request->password, $user->password)) {
                return response()->json(['message' => 'Invalid password'], 401);
            }
        }

        // // تحقق إذا اليوزر هو admin (حسب role_id أو حسب نظامك)
        // // مثلاً: role_id = 1 يعني admin
        // if ($user->role_id != 1) {
        //     return response()->json(['message' => 'Unauthorized: Not admin'], 403);
        // }


        // إنشاء توكن باستخدام Sanctum
        $token = $user->createToken('AdminAccessToken')->plainTextToken;

        return response()->json([
            'data'  => $user,
            'token' => $token,
        ], 200);
    }
}
