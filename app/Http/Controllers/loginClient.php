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
        'mobile_number' => 'required|max:10',
    ]);

    if ($validator->fails()) {
        return response()->json(['error' => 'Invalid Parameters'], 401);
    }

    // البحث عن العميل في قاعدة البيانات أو إنشاؤه
    $user = User::firstOrCreate(
        ['mobile_number' => $request->mobile_number],
        ['role_id' => 2] // إذا جديد نخزنه كـ client
    );

    // تأكد من أن علاقة role موجودة (اختياري إذا عندك علاقة)
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
