<?php

return [
    // هذا المسار لملف JSON اللي نزلته من Firebase
    'credentials_file' => storage_path('app/firebase/firebase_credentials.json'),
];
// //use Kreait\Firebase\Factory;
// use Kreait\Firebase\Messaging\CloudMessage;

// // نقرأ ملف JSON من الـ config
// $factory = (new Factory)->withServiceAccount(config('firebase.credentials_file'));

// // نعمل Messaging instance
// $messaging = $factory->createMessaging();
