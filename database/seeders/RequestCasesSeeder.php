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
                'description'    => 'جمع 100 كرسي ',
                'userName'       => 'محمد',
                'email'          => 'mohammed@example.com',
                'mobile_number' => '0977123456',
                'importance'     => 5,
                'status_id'      => 1, // Pending
                'case_c_id'      => 1, // حملة دفء الشتاء
                'user_id'        => 1, // محمد
            ],
            [
                'description'    => 'توفير لوازم مدرسية.',
                'userName'       => 'لانا',
                'email'          => 'lana@example.com',
                'mobile_number'  => '0977123456',
                'importance'     => 3,
                'status_id'      => 2, // Accepted
                'case_c_id'      => 2, // جمع كراسي
                'user_id'        => 3, // لانا
            ],
            [
                'description'    => 'مساعدة لترميم الفصول الدراسية.',
                'userName'       => 'عمر',
                'email'          => 'omar@example.com',
                'mobile_number'  => '0912345678',
                'importance'     => 4,
                'status_id'      => 3, // In Review
                'case_c_id'      => 3, // ترميم مدرسة السلام
                'user_id'        => 4, // عمر
            ],
        ];

        DB::table('request_cases')->insert($cases);
    }
}
