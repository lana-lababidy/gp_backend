<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RequestChargesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $requests = [
            [
                'quantity' => 100,
                'amount' => 50.00,
                'user_id' => 2, // محمود
                'status_id' => 1, // Pending
            ],
            [
                'quantity' => 200,
                'amount' => 150.00,
                'user_id' => 3, // لانا
                'status_id' => 2, // Approved
            ],
            [
                'quantity' => 50,
                'amount' => 25.00,
                'user_id' => 4, // عمر
                'status_id' => 3, // Declined
            ],
        ];

        DB::table('request_charges')->insert($requests);
    }
}
