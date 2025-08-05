<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WalletSeeder extends Seeder
{
    public function run(): void
    {
        // نضيف محفظة لكل مستخدم موجود في الجدول، مع نقاط مبدئية (مثلاً 0)
        $wallets = [
            ['user_id' => 1, 'total_points' => 100], // محمد
            ['user_id' => 2, 'total_points' => 50],  // محمود
            ['user_id' => 3, 'total_points' => 200], // لانا
            ['user_id' => 4, 'total_points' => 75],  // عمر
        ];

        foreach ($wallets as $wallet) {
            DB::table('wallets')->updateOrInsert(
                ['user_id' => $wallet['user_id']],
                ['total_points' => $wallet['total_points']]
            );
        }
    }
}
