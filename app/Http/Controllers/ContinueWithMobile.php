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

        //التحقق من OTP & الرقم 
        $otpRecord = Otp::where('mobile_number', $request->mobile_number)
            ->where('otp', $request->otp)
            ->where('expires_at', '>', now()) // OTP لم تنتهِ صلاحيته
            //لوقت الحالي يجب أن يكون أقل من وقت انتهاء صلاحية الـ OTP.
            ->first(); // دالة بتجيب أول سجل بطابق الشروط المحددة 

        // إذا كان الـ OTP غير صحيح أو منتهي الصلاحية
        if (!$otpRecord) {
            return response()->json(['error' => 'invalid OTP'], 401);
        }
//التأكد اذا المستخدم موجود واذا لا createToken (بتجيب القديم)

        $user = User::where('mobile_number', $request->mobile_number)->first();
        $token = $user->createToken('MobileAccessToken')->accessToken;
        if (!$user) {
            $user = User::create([
                'mobile_number' => $request->mobile_number,
            ]);
        }
        return response()->json([
            'data' => $user,
            'token' => $token,
        ], 200);
    }
}
