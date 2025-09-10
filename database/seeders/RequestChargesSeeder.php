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
                /*quantity = عدد النقاط
amount = السعر المالي لهذه النقاط */
                'quantity' => 100,
                'amount' => 100000,
                'user_id' => 2, // محمود
                'status_id' => 1, // Pending
            ],
            [
                'quantity' => 2000,
                'amount' => 2000000,
                'user_id' => 3, // لانا
                'status_id' => 2, // Approved
            ],
            [
                'quantity' => 250,
                'amount' => 250000,
                'user_id' => 4, // عمر
                'status_id' => 3, // Declined
            ],
        ];

        DB::table('request_charges')->insert($requests);
    }
}
