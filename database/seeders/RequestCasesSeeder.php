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
                'description' => 'تأمين بطانيات وملابس شتوية للأسر المحتاجة.',
                'userName'          => 'محمد',
                'mobile_number'     => '0977123456',
                'importance'        => 5,
                'status_id'         => 5, // completed
                'case_c_id'         => 1, // حملة دفء الشتاء
                'user_id'           => 1, // محمد
                'donation_type_id' => 2, // ✅ تبرع عيني مثلاً
                'goal_quantity'     => 150,
                'fulfilled_quantity' => 30, // تم جمع 30 كرسي
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
                'donation_type_id' => 2, // ✅ تبرع عيني مثلاً
                'fulfilled_quantity' => 50, // اكتمل الدعم
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
                'donation_type_id' => 3, // ✅ جهد شخصي
                'fulfilled_quantity' => 120, // تم تنفيذ 60% من العمل
            ], [
                'title' => 'حملة التبرع بالدم',
                'description' => 'حملة لجمع 200 وحدة دم لصالح مستشفى المدينة.',
                'userName'          => 'سارة',
                'mobile_number'     => '0987654321',
                'importance'        => 5,
                'status_id'         => 1, // New
                'case_c_id'         => 4,
                'user_id'           => 3,
                'goal_quantity'     => 200,
                'donation_type_id'  => 1, // تبرع مالي / دم
                'fulfilled_quantity'=> 60,
            ],
            [
                'title' => 'توزيع وجبات إفطار',
                'description' => 'تأمين 500 وجبة إفطار خلال شهر رمضان للفقراء.',
                'userName'          => 'نور',
                'mobile_number'     => '0999888777',
                'importance'        => 4,
                'status_id'         => 2, // Accepted
                'case_c_id'         => 5,
                'user_id'           => 1,
                'goal_quantity'     => 500,
                'donation_type_id'  => 2, // تبرع عيني (وجبات)
                'fulfilled_quantity'=> 150,
            ],
            [
                'title' => 'تأمين أدوية مزمنة',
                'description' => 'تأمين أدوية لمرضى السكري والضغط في القرى البعيدة.',
                'userName'          => 'ليلى',
                'mobile_number'     => '0955332211',
                'importance'        => 5,
                'status_id'         => 4, // Pending Approval
                'case_c_id'         => 6,
                'user_id'           => 2,
                'goal_quantity'     => 1000,
                'donation_type_id'  => 2, // أدوية = عيني
                'fulfilled_quantity'=> 200,
            ],
        ];

        DB::table('request_cases')->insert($cases);
    }
}
