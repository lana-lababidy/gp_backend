<?php

namespace App\Http\Controllers;

use App\Models\Otp;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class ContinueWithEmail extends Controller
{

    public function ContinueWithEmail(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'otp' => 'required|string|min:4|max:4',
        ]);

        
        $email = $request->input('email');
        $otp = $request->input('otp');

        // جلب المستخدم حسب الايميل
        $user = User::where('email', $email)->first();

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        // افتراض: يوجد حقل otp في جدول users أو طريقة تحقق من الـ OTP
        // مثال: تحقق من otp في العمود user->otp
        if ($user->otp !== $otp) {
            return response()->json(['message' => 'Invalid OTP'], 401);
        }

        // لو عندك علاقة Sessions في User
        // نفترض sessions علاقة hasMany وتريد ترجعها مع المستخدم
        $sessions = $user->sessions()->get();

        // ممكن تنشئ session جديد لو حابب
        // $session = $user->sessions()->create([...]);

        return response()->json([
            'user' => $user,
            'sessions' => $sessions,
        ], 200);

        // if ($validator->fails()) {
        //     return response()->json(['error' => 'Invalid Parameters'], 401);
        // }

        // //التحقق من OTP & الرقم 
        // $otpRecord = Otp::where('email', $request->email)

        //     ->where('otp', $request->otp)
        //     ->where('expires_at', '>', now()) // OTP لم تنتهِ صلاحيته
        //     //لوقت الحالي يجب أن يكون أقل من وقت انتهاء صلاحية الـ OTP.
        //     ->first(); // دالة بتجيب أول سجل بطابق الشروط المحددة 

        // // إذا كان الـ OTP غير صحيح أو منتهي الصلاحية
        // if (!$otpRecord) {
        //     return response()->json(['error' => 'invalid OTP'], 401);
        // }
        // //التأكد اذا المستخدم موجود واذا لا createToken (بتجيب القديم)

        // $user = User::where('email', $request->email)->first();
        // // $token = $user->createToken('EmailAccessToken')->accessToken;
        // if (!$user) {
        //     $user = User::create([
        //         'email' => $request->email,
        //     ]);
        // }
        // $token = $user->createToken('MobileAccessToken')->plainTextToken;

        // return response()->json([
        //     'data' => $user,
        //     'token' => $token,
        // ], 200);

    }
}
