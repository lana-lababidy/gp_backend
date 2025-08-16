<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DonationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
  public function run(): void
    {
        $donations = [
            [
                'quantity' => 10,
                'donation_type_id' => 2, // in_kind
                'status_id' => 1, // Pending
                'user_id' => 4, // عمر
                'case_c_id' => 1, // حملة دفء الشتاء
            ],
            [
                'quantity' => 2500,
                'donation_type_id' => 1, // money
                'status_id' => 2, // Accepted
                'user_id' => 2, // محمود
                'case_c_id' => 2, // جمع 100 كرسي
            ],
            [
                'quantity' => 500,
                'donation_type_id' => 3, // service
                'status_id' => 3, // Completed
                'user_id' => 3, // لانا
                'case_c_id' => 3, // ترميم مدرسة السلام
            ],
        ];

        foreach ($donations as $donation) {
            DB::table('donations')->insert($donation);
        }
    }
}