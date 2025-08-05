<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{    public function run(): void
    { // إنشاء admin
        User::create([
            'username' => 'محمد',
            'aliasname' => 'البطل',
            'password' => '123456',
            'user_session' => null, // لا يتم ملؤها
            'fcm_token' => null, // لا يتم ملؤها
    
        ]);

        // إنشاء زبون
        User::create([
                'username' => 'محمود',
            'aliasname' => 'الوحش',
            'password' => '654321',
            'user_session' => null, // لا يتم ملؤها
            'fcm_token' => null, // لا يتم ملؤها
    
        ]);

        // إنشاء زبون
        User::create([
                  'username' => 'لانا',
            'aliasname' => 'البطلة',
            'password' => '231020',
            'user_session' => null, // لا يتم ملؤها
            'fcm_token' => null, // لا يتم ملؤها
    
        ]);

        // إنشاء زبون
        User::create([
      'username' => 'عمر',
            'aliasname' => 'المتبرع الفهيم',
            'password' => '456789',
            'user_session' => null, // لا يتم ملؤها
            'fcm_token' => null, // لا يتم ملؤها
    
        ]);
    }
}