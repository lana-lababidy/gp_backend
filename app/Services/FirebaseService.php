<?php

namespace App\Services;

use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;

class FirebaseService
{
    protected $messaging;

    public function __construct()
    {
        // Use storage_path helper to get the full path to the service account JSO
        $serviceAccountPath = storage_path
        
        // storage\
        ('app\firebase\firebase_credentials.json');
        $factory = (new Factory)->withServiceAccount($serviceAccountPath);
        $this->messaging = $factory->createMessaging();
    }

    public function sendNotification($token, $title, $body, $data = [])
    {
        $message = CloudMessage::withTarget('token', $token)
            ->withNotification(['title' => $title, 'body' => $body])
            ->withData($data);

        $this->messaging->send($message);
    }
}
    

// الاستخدام
/*1️⃣ استيراد الخدمة

أول شيء لازم تستورد الخدمة جوّا الكنترولر:

use App\Services\FirebaseService;

2️⃣ تعريف الدالة مع DI

لما تكتب الدالة زي هيك:

public function store(Request $request, FirebaseService $firebase)


Laravel رح يلاحظ إنك طالب FirebaseService ويصنعلك نسخة منها أوتوماتيك من Service Container.
يعني ما في داعي تعمل:

$firebase = new FirebaseService();


Laravel رح يعملها تلقائيًا.

3️⃣ استخدام الخدمة لإرسال الإشعار

بعد ما تحفظ البيانات (مثلاً الحالة الجديدة)، استعمل $firebase مباشرة:

$case = CaseModel::create($request->all());

if ($request->user()->fcm_token) {
    $firebase->sendNotification(
        $request->user()->fcm_token,     // توكين الجهاز من Flutter
        'تمت إضافة حالة',               // عنوان الإشعار
        "تمت إضافة حالتك: {$case->title}" // نص الإشعار
    );
}

4️⃣ إرجاع Response

مثل أي دالة أخرى بالـ API:

return response()->json([
    'message' => 'تم الحفظ بنجاح',
    'id' => $case->id
]);

✅ مميزات Dependency Injection

أنضف وأكثر وضوحًا من إنشاء الكائن يدويًا (new FirebaseService()).

أسهل بالاختبارات: فيك تعمل Mock أو Fake للإشعارات بدون تعديل الكود.

مرونة أعلى: لو احتجت تغير الإعدادات في المستقبل، Laravel Container يتعامل مع كل شيء تلقائيًا.  

*/