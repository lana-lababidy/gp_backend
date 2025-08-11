<?php

// use App\Http\Controllers\CaseController;
use App\Http\Controllers\ContinueWithEmail;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\generateOtp;
use App\Http\Controllers\loginAdmin;
use App\Http\Controllers\loginClient;
use App\Http\Controllers\generateOtpMobile;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\SecretInfoController;
use App\Http\Controllers\UpdateSecretInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CaseController;
use App\Http\Controllers\RequestCaseController;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
}); 

Route::post('/generate-otp', [generateOtp::class, 'generateOtp']);

Route::post('/continue-with-email', [ContinueWithEmail::class, 'ContinueWithEmail']);

// Route::middleware('auth:sanctum')->post('/update-secret-info', [UpdateSecretInfo::class, 'update']);
Route::post('/login-admin', [loginAdmin::class, 'login']);





// Route::get('/cases', [CaseController::class, 'index']);


Route::post('/donations', [DonationController::class, 'createDonation']); // للمستخدمين
Route::patch('/donations/{id}/status', [DonationController::class, 'updateDonationStatus']); // للأدمن






//شغالين    flutter
Route::post('/login-client', [loginClient::class, 'loginClient']);

Route::post('/Otp-Mobile', [generateOtpMobile::class, 'generateOtpMobile']);

// لجلب كل الـ SecretInfos
Route::get('/secret-info', [SecretInfoController::class, 'index']);

// لجلب الـ SecretInfos لمستخدم معين
Route::get('/users/{user_id}/secret-info', [SecretInfoController::class, 'getByUser']);

Route::post('/secret-info', [SecretInfoController::class, 'store']);

Route::put('/secret-info/{id}', [SecretInfoController::class, 'update']);

Route::patch('/secret-info/{id}', [SecretInfoController::class, 'update']);

/*
PUT:
 لتحديث السجل بالكامل.
PATCH:
يُستخدم لتحديث جزء من السجل فقط، يعني تبعت فقط الحقول اللي بدك تعدلها.
 */
//عرض كل الحالات مع تفاصيلها 
Route::get('/cases', [CaseController::class, 'index']);

//عرض حالة معينة بالتفصيل
Route::get('/cases/{id}', [CaseController::class, 'show']);

//إنشاء حالة جديدة
Route::post('/cases', [CaseController::class, 'store']);

//عرض كل طلبات الحالات (يشمل حالة الطلب، وصف، رقم الهاتف...)
Route::get('/request-cases', [RequestCaseController::class, 'index']);
//عرض طلب حالة معين
Route::get('/request-cases/{id}', [RequestCaseController::class, 'show']);
//إنشاء طلب حالة جديد
Route::post('/request-cases', [RequestCaseController::class, 'store']);
 
// عرض كل حالات طلب الحالة التفاصيل