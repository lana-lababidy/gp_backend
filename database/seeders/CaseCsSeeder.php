<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CaseCsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cases = [
            [
                'title' => 'حملة دفء الشتاء',
                'description' => 'تأمين بطانيات وملابس شتوية للأسر المحتاجة.',
                'goal_amount' => 150000,
                'points' => intval(150000 / 1000),       // 500 نقطة من المبلغ

                'states_id' => 1, // Pending
                'donation_type_id' => 2, // in_kind
                'user_id' => 1, // محمد
            ],
            [

                'title' => 'جمع 100 كرسي ',
                'description' => 'مدرسة بحاجة الى 100 كرسي قبل بداية العام الدراسي',
                'goal_amount' => 300000,
                'points' => intval(300000 / 1000),       // 300 نقطة

                'states_id' => 5, // In Progress
                'donation_type_id' => 1, // money
                'user_id' => 3, // لانا
            ],
            [
                'title' => 'ترميم مدرسة السلام',
                'description' => 'صيانة وترميم مرافق مدرسة السلام في الريف.',
                'goal_amount' => 800000,
                'points' => intval(800000 / 1000),       // 800 نقطة
                'states_id' => 2, // Completed
                'donation_type_id' => 3, // service
                'user_id' => 4, // عمر
            ],
        ];

        foreach ($cases as $case) {
            DB::table('case_cs')->insert($case);
        }
    }
}
