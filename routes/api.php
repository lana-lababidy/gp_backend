<?php
use App\Http\Controllers\ContinueWithEmail;
use App\Http\Controllers\generateOtp;
use App\Http\Controllers\loginAdmin;
use App\Http\Controllers\loginClient;

use App\Http\Controllers\UpdateSecretInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('/generate-otp', [generateOtp::class, 'generateOtp']);

Route::post('/continue-with-email', [ContinueWithEmail::class, 'ContinueWithEmail']);

Route::get('/test', function () {
    return response()->json(['message' => 'API is working']);
});

Route::post('/login-client', [loginClient::class, 'loginClient']);

Route::middleware('auth:sanctum')->post('/update-secret-info', [UpdateSecretInfo::class, 'update']);
Route::post('/login-admin', [loginAdmin::class, 'login']);
