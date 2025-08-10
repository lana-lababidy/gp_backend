<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;
use App\Models\Otp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class generateOtpMobile extends Controller
{
    public function generateOtpMobile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mobile_number' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        //random 4-digit OTP
        $otp = random_int(1000, 9999);

        Otp::create(attributes: [
            'otp' => $otp,
            'mobile_number' => $request->mobile_number,
            'is_used' => false,
            'expires_at' => now()->addMinutes(5), // صلاحية 5 دقائق

        ]);

        return response()->json(
            data: [
                'message' => 'OTP generated and sent successfully',
                'data' => $otp,
            ],
        );
    }
}
