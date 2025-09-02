<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Otp;

class ContinueWithMobile extends Controller
{
   public function continueWithMobile(Request $request)
{
    $validator = Validator::make($request->all(), [
        'mobile_number' => 'required|string',
        'otp' => 'required|string|min:4|max:4',
    ]);

    if ($validator->fails()) {
        return response()->json(['error' => 'Invalid Parameters'], 401);
    }

    // التحقق من OTP
    $otpRecord = Otp::where('mobile_number', $request->mobile_number)
        ->where('otp', $request->otp)
        ->where('expires_at', '>', now())
        ->first();

    if (!$otpRecord) {
        return response()->json(['error' => 'Invalid OTP'], 401);
    }

    // إذا المستخدم جديد، أنشئه
    $user = User::where('mobile_number', $request->mobile_number)->first();
    if (!$user) {
        $user = User::create([
            'mobile_number' => $request->mobile_number,
            'username'      => $request->mobile_number, // أو أي قيمة افتراضية
            'password'      => bcrypt(''),              // إذا عندك NOT NULL بالجدول
            'role_id'       => 2,                       // لو بدك تحدد role client
        ]);
    }

    // إنشاء التوكن
    $token = $user->createToken('MobileAccessToken')->plainTextToken;

    return response()->json([
        'data'  => $user,
        'token' => $token,
    ], 200);
}
}
