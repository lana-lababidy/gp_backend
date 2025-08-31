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
        $factory = (new Factory)->withServiceAccount(env('FIREBASE_CREDENTIALS'));
        $this->messaging = $factory->createMessaging();
    }

    public function sendNotification($token, $title, $body)
    {
        $message = CloudMessage::withTarget('token', $token)
            ->withNotification(Notification::create($title, $body));

        return $this->messaging->send($message);
    }
}
    

// الاستخدام
/*
use App\Services\FirebaseService;


$firebase = new FirebaseService();
$firebase->sendNotification($user->USER_FCM_TOKEN, 'عنوان الإشعار', 'نص الإشعار');

استبدل USER_FCM_TOKEN بالـ token يلي جاي من تطبيق Flutter. 

*/