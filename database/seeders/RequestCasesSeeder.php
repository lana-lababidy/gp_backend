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

                'title' => 'حملة دفء الشتاء',
                'description' => 'تأمين بطانيات وملابس شتوية للأسر المحتاجة.',                'userName'          => 'محمد',
                'mobile_number'     => '0977123456',
                'importance'        => 5,
                'status_id'         => 5, // completed
                'case_c_id'         => 1, // حملة دفء الشتاء
                'user_id'           => 1, // محمد
                'goal_quantity'     => 150,
                'fulfilled_quantity'=> 30, // تم جمع 30 كرسي
            ],
            [
                      'title' => 'جمع 100 كرسي ',
                'description' => 'مدرسة بحاجة الى 100 كرسي قبل بداية العام الدراسي',
                'userName'          => 'لانا',
                'mobile_number'     => '0977123456',
                'importance'        => 3,
                'status_id'         => 2, // Accepted
                'case_c_id'         => 2, // جمع كراسي
                'user_id'           => 3, // لانا
                'goal_quantity'     => 300,
                'fulfilled_quantity'=> 50, // اكتمل الدعم
            ],
            [
                'title' => 'ترميم مدرسة السلام',
                'description' => 'صيانة وترميم مرافق مدرسة السلام في الريف.',
                'userName'          => 'عمر',
                'mobile_number'     => '0912345678',
                'importance'        => 4,
                'status_id'         => 3, // In Review
                'case_c_id'         => 3, // ترميم مدرسة السلام
                'user_id'           => 4, // عمر
                'goal_quantity'     => 800,
                'fulfilled_quantity'=> 120, // تم تنفيذ 60% من العمل
            ],
        ];

        DB::table('request_cases')->insert($cases);
    }
}
