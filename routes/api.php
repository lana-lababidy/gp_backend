<?php

use App\Http\Controllers\Api\CaseController;
use App\Http\Controllers\ContinueWithEmail;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\generateOtp;
use App\Http\Controllers\loginAdmin;
use App\Http\Controllers\loginClient;
use App\Http\Controllers\generateOtpMobile;
use App\Http\Controllers\SecretInfoController;
use App\Http\Controllers\UpdateSecretInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('/generate-otp', [generateOtp::class, 'generateOtp']);

Route::post('/continue-with-email', [ContinueWithEmail::class, 'ContinueWithEmail']);

// Route::middleware('auth:sanctum')->post('/update-secret-info', [UpdateSecretInfo::class, 'update']);
Route::post('/login-admin', [loginAdmin::class, 'login']);





Route::get('/cases', [CaseController::class, 'index']);


Route::post('/donations', [DonationController::class, 'createDonation']); // للمستخدمين
Route::patch('/donations/{id}/status', [DonationController::class, 'updateDonationStatus']); // للأدمن


//شغالين    flutter
Route::post('/login-client', [loginClient::class, 'loginClient']);

Route::post('/Otp-Mobile', [generateOtpMobile::class, 'generateOtpMobile']);

// لجلب كل الـ SecretInfos
Route::get('/secret-info', [SecretInfoController::class, 'index']);

// لجلب الـ SecretInfos لمستخدم معين
Route::get('/users/{user_id}/secret-info', [SecretInfoController::class, 'getByUser']);
//http://127.0.0.1:8000/api/users/2/secret-info

Route::post('/secret-info', [SecretInfoController::class, 'store']);

Route::put('/secret-info/{id}', [SecretInfoController::class, 'update']);

Route::patch('/secret-info/{id}', [SecretInfoController::class, 'update']);

/*الفرق بين PUT و PATCH:
PUT:
يُستخدم لتحديث السجل بالكامل، يعني لازم تبعت كل الحقول (حتى لو ما تغيرت)، لأنه يعيد استبدال البيانات كلها.

PATCH:
يُستخدم لتحديث جزء من السجل فقط، يعني تبعت فقط الحقول اللي بدك تعدلها.

 */