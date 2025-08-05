<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DonationStatusesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = [
            ['name' => 'Pending', 'code' => 1],
            ['name' => 'Accepted', 'code' => 2],
            ['name' => 'Completed', 'code' => 3],
            ['name' => 'Declined', 'code' => 4],
        ];

        foreach ($statuses as $status) {
            DB::table('donation_statuses')->updateOrInsert(['code' => $status['code']], $status);
        }
    }
}
