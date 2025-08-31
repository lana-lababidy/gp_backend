<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class OtpSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('otps')->insert([
            [
                'otp' => '1234',
                'is_used' => false,
                'expires_at' => Carbon::now()->addMinutes(5),
                'mobile_number' => '0968879073',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'otp' => '5678',
                'is_used' => true,
                'expires_at' => Carbon::now()->subMinutes(2), // انتهت صلاحيتها
                'mobile_number' => '0947214749',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
