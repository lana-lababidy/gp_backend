<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use App\Models\Otp;
use Illuminate\Http\Request;

class generateOtp extends Controller
{

    public function generateOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        //random 4-digit OTP
        $otp = random_int(1000, 9999);

        Otp::create(attributes: [
            'otp' => $otp,
            'email' => 'required|email',
            'is_used' => false,
        ]);

        return response()->json(
            data: [
                'message' => 'OTP generated and sent successfully',
                'data' => $otp,
            ],
        );
    }
}
