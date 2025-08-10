<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Otp;
use Carbon\Carbon;

class OtpSeeder extends Seeder
{
    public function run(): void
    {
        // Otp::create([
        //     'email' => 'lana@example.com',
        //     'otp' => '1234',
        //     'is_used' => false,
        //     'expires_at' => Carbon::now()->addMinutes(10),
        // ]);
    }
}
