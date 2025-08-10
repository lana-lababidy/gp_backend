<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use App\Models\Session;
use Illuminate\Support\Facades\Hash;

class TestDataSeeder extends Seeder
{
    public function run()
    {
        // 1. إنشاء دور
        $role = Role::firstOrCreate(
            ['name' => 'admin'],
            ['description' => 'Administrator role']
        );

        // 2. إنشاء مستخدم
$user = User::firstOrCreate(
    ['username' => 'testuser'],
    [
        'password' => Hash::make('password123'),
        'mobile_number' => '0999999999',
        'role_id' => 1, // رقم الدور المناسب
    ]
);


        // 3. ربط الدور بالمستخدم (عبر علاقة roles())
        if (!$user->roles()->where('role_id', $role->id)->exists()) {
            $user->roles()->attach($role->id);
        }

        // 4. إنشاء جلسة مرتبطة بالمستخدم مع توكن ثابت
        $sessionToken = 'testtoken123';

        Session::updateOrCreate(
            ['user_id' => $user->id],
            ['session_token' => $sessionToken]
        );

        $this->command->info('Test user, role and session created successfully.');
    }
}
