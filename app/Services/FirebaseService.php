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
        $serviceAccountPath = storage_path('storage\app\firebase\firebase_credentials.json');
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
/*
use App\Services\FirebaseService;


$firebase = new FirebaseService();
$firebase->sendNotification($user->USER_FCM_TOKEN, 'عنوان الإشعار', 'نص الإشعار');

استبدل USER_FCM_TOKEN بالـ token يلي جاي من تطبيق Flutter. 

*/