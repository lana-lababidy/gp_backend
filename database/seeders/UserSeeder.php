<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    { // إنشاء admin
        User::create([
            'username' => 'محمد',
            'aliasname' => 'البطل',
            'password' =>  Hash::make('231020'),
            'user_session' => null, // لا يتم ملؤها
            'fcm_token' => null, // لا يتم ملؤها
            'role_id' => 1,
            'mobile_number' => '0934271139',

        ]);

        // إنشاء زبون
        User::create([
            'username' => 'محمود',
            'aliasname' => 'الوحش',
            'password' => Hash::make('54321'),
            'user_session' => null, // لا يتم ملؤها
            'fcm_token' => null, // لا يتم ملؤها
            'mobile_number' => '0947214749',
            'role_id' => 2,

        ]);

        // إنشاء زبون
        User::create([
            'username' => 'لانا',
            'aliasname' => 'البطلة',
            'password' => Hash::make('231020'),
            'user_session' => null, // لا يتم ملؤها
            'fcm_token' => null, // لا يتم ملؤها
            'role_id' => 2,
            'mobile_number' => '0968879073',

        ]);

        // إنشاء زبون
        User::create([
            'username' => 'عمر',
            'aliasname' => 'المتبرع الفهيم',
            'password' => Hash::make('456789'),
            'user_session' => null, // لا يتم ملؤها
            'fcm_token' => null, // لا يتم ملؤها
            'role_id' => 2,
            'mobile_number' => '0956976021',

        ]);
    }
}
