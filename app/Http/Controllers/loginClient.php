<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class loginClient extends Controller
{

    public function loginClient(Request $request)
    {
        // التحقق من المدخلات
        $validator = Validator::make($request->all(), [
            // 'username' => 'required|string',
            'mobile_number' => 'required|max:10',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'Invalid Parameters'], 401);
        }

        // البحث عن العميل في قاعدة البيانات
        $user = User::where('mobile_number', $request->mobile_number)
        // where('username', $request->username)
            
            ->where('role_id', '2')
            ->first();

        if (!$user) {
            return response()->json(['message' => 'Invalid username, mobile number, or unauthorized'], 401);
        }
        //  تأكد من أن علاقة `role` موجودة في `User`:
        if (!$user->role || $user->role->name !== 'client') {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        // إنشاء Access Token
        $token = $user->createToken('ClientAccessToken')->plainTextToken;

        return response()->json([
            'data' => $user,
            'token' => $token
        ]);
    }
    // تسجيل الخروج
    public function logoutClient(Request $request)
    {
        // يمسح الـ token الخاص بالـ client الذي أرسل الطلب
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logged out successfully'
        ]);
    }
}
