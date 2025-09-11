<?php

use App\Http\Controllers\NotificationController;
use App\Http\Middleware\AdminMiddleware;

use App\Http\Controllers\UserProfileController;
// use App\Http\Controllers\CaseController;
use App\Http\Controllers\ContinueWithMobile;
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
use App\Http\Controllers\CaseGalleryController;
use App\Http\Controllers\DonorRankingController;
use App\Http\Controllers\RequestCaseController;
use App\Http\Controllers\RequestCaseGalleryController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FqaController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RequestChargeController;
use App\Http\Controllers\WalletController;
use App\Http\Middleware\ClientMiddleware;


Route::patch('/donations/{id}/status', [DonationController::class, 'updateDonationStatus']); // للأدمن
Route::post('/send-notification', [NotificationController::class, 'sendPushNotification']);

//____________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________


/* للأدمن API  */
Route::post('/login-admin', [loginAdmin::class, 'login']);

// Route::prefix('admin')->middleware(['auth:sanctum', 'role:admin'])->group(function () {

//   Route::get('/dashboard', function () {
//     return response()->json(['msg' => 'أنت أدمن']);
//   });
// لجلب كل الـ SecretInfos
Route::get('/secret-info', [SecretInfoController::class, 'index']);

// لجلب الـ SecretInfos لمستخدم معين
Route::get('/users/{user_id}/secret-info', [SecretInfoController::class, 'getByUser']);

//تعديل يوزر
Route::put('/users/{id}', [UserController::class, 'update']);

Route::delete('/users/{id}', [UserController::class, 'destroy']);

//تعديل حالة الطلبات يدويً
Route::put('/requests/{id}/status', [RequestCaseController::class, 'updateStatus']);

/*للاسئلة الشائعة */
Route::post('/fqas', [FqaController::class, 'store']);

Route::put('/fqas/{id}', [FqaController::class, 'update']);

Route::delete('/fqas/{id}', [FqaController::class, 'destroy']);

//يعرض ملخص كامل للإحصائيات بالموقع: عدد المستخدمين، عدد التبرعات، إجمالي الكميات المتبرع فيها، وعدد الطلبات المكتملة.
Route::get('/reports/statistics', [ReportController::class, 'statistics']);

//تعديل
Route::put('/request-cases/{id}', [RequestCaseController::class, 'update']);

Route::delete('/request-cases/{id}', [RequestCaseController::class, 'destroy']);

//2 الادمن يشوف كل الطلبات بانتظار المراجعة
Route::post('/request-cases/pending', [RequestCaseController::class, 'pendingRequests']);

//4الادمن يرفض الطلب 
Route::post('/request-cases/{id}/reject', [RequestCaseController::class, 'rejectRequest']);

// الادمن يقبل الطلب → يتحول إلى Case أساسي
Route::post('/request-cases/{id}/approve', [RequestCaseController::class, 'approveRequest']);

// معالجة طلبات الشحن
// الأدمن يوافق على طلب
Route::post('/request-charge/{id}/approve', [RequestChargeController::class, 'approve']);

// الأدمن يرفض طلب
Route::post('/request-charge/{id}/reject', [RequestChargeController::class, 'reject']);
// });

//الادمن بشوف الطلبات الPending
Route::get('/admin/wallet/requests', [WalletController::class, 'getPendingRequests']);

// الأدمن يرفض او يوافق طلب
Route::post('/admin/wallet/process', [WalletController::class, 'processRequest']);

//____________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________


//شغالين    flutter

Route::post('/login-client', [loginClient::class, 'loginClient']);
// Route::post('/login-client', [loginClient::class, 'loginClient'])->name('login');

// Route::prefix('client')->middleware(['auth:sanctum', 'role:client'])->group(function () {


// Route::get('/profile', function () {
//   return response()->json(['msg' => 'أنت مستخدم عادي']);
// });

Route::post('/generate-otp', [generateOtpMobile::class, 'generateOtpMobile']);

Route::post('/cwm', [continueWithMobile::class, 'continueWithMobile']);

/* first module secret-info */

Route::post('/secret-info', [SecretInfoController::class, 'store']);
//صفحة البروفايل
Route::put('/secret-info/{id}', [SecretInfoController::class, 'update']);

Route::patch('/secret-infos/user/{user_id}', [SecretInfoController::class, 'getByUser']);

/*  request-cases*/
//عرض كل طلبات الحالات (يشمل حالة الطلب، وصف، رقم الهاتف...)
Route::get('/request-cases', [RequestCaseController::class, 'index']);
//عرض طلب حالة معين
Route::get('/request-cases/{id}', [RequestCaseController::class, 'show']);
//إنشاء طلب حالة جديد
Route::post('/request-cases', [RequestCaseController::class, 'store']);

/*
PUT:
 لتحديث السجل بالكامل.
PATCH:
يُستخدم لتحديث جزء من السجل فقط، يعني تبعت فقط الحقول اللي بدك تعدلها.
 */


/*  cases   فلترة /cases?donation_type=1 
/cases?donation_type=2 //// /cases?donation_type=3
+ بحث  cases?search=----*/
//عرض كل الحالات مع تفاصيلها 
Route::get('/cases', [CaseController::class, 'index']);

//عرض حالة معينة بالتفصيل
Route::get('/cases/{id}', [CaseController::class, 'show']);

//إنشاء حالة جديدة
// Route::post('/cases', [CaseController::class, 'store']);

//عرض نسبة التقدم
Route::get('progress/{id}', [RequestCaseController::class, 'progress']);



/*Donation*/
//إضافة تبرع جديد (Donation) في
Route::post('/donations', [DonationController::class, 'store']); // للمستخدمين'

//بتعرض كل التبرعات 
Route::get('/donations', [DonationController::class, 'index']);

// تفاصيل تبرع واحد
Route::get('/donations/{id}', [DonationController::class, 'show']);

// بتعرض تبرع خاص بحالة 
Route::get('/requests/{id}/donations', [DonationController::class, 'donationsByRequest']);


/*فكرة ال rank*/
//قائمة ترتيب للمتبرعين حسب نقاطهم،
Route::get('/donors/ranking', [DonorRankingController::class, 'index']);

/*gallery */
// معرض الحالة
Route::get('/cases/{caseId}/gallery', [GalleryController::class, 'getCaseGallery']);

Route::post('/cases/{caseId}/gallery', [GalleryController::class, 'storeCaseGallery']);

// معرض طلب الحالة
Route::get('/requests/{requestId}/gallery', [GalleryController::class, 'getRequestGallery']);

Route::post('/requests/{requestId}/gallery', [GalleryController::class, 'storeRequestGallery']);


// عرض كل الأسئلة الشائعة مع الإجابات
Route::get('/faqs', [FqaController::class, 'index']);
// });


// المستخدم يرسل طلب شحن
Route::post('/wallet/topup', [WalletController::class, 'requestTopup']);

    // عرض رصيد المستخدم
Route::get('/wallet/balance/{user_id}', [WalletController::class, 'getBalance']);
