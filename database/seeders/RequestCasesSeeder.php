<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RequestCasesSeeder extends Seeder
{
    public function run(): void
    {
        $cases = [
            [
                'description'       => 'جمع 100 كرسي',
                'userName'          => 'محمد',
                'email'             => 'mohammed@example.com',
                'mobile_number'     => '0977123456',
                'importance'        => 5,
                'status_id'         => 5, // completed
                'case_c_id'         => 1, // حملة دفء الشتاء
                'user_id'           => 1, // محمد
                'goal_quantity'     => 100,
                'fulfilled_quantity'=> 30, // تم جمع 30 كرسي
            ],
            [
                'description'       => 'توفير لوازم مدرسية.',
                'userName'          => 'لانا',
                'email'             => 'lana@example.com',
                'mobile_number'     => '0977123456',
                'importance'        => 3,
                'status_id'         => 2, // Accepted
                'case_c_id'         => 2, // جمع كراسي
                'user_id'           => 3, // لانا
                'goal_quantity'     => 50,
                'fulfilled_quantity'=> 50, // اكتمل الدعم
            ],
            [
                'description'       => 'مساعدة لترميم الفصول الدراسية.',
                'userName'          => 'عمر',
                'email'             => 'omar@example.com',
                'mobile_number'     => '0912345678',
                'importance'        => 4,
                'status_id'         => 3, // In Review
                'case_c_id'         => 3, // ترميم مدرسة السلام
                'user_id'           => 4, // عمر
                'goal_quantity'     => 200,
                'fulfilled_quantity'=> 120, // تم تنفيذ 60% من العمل
            ],
        ];

        DB::table('request_cases')->insert($cases);
    }
}
