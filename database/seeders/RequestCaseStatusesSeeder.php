<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RequestCaseStatusesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
                $statuses = [
            ['name' => 'Pending', 'code' => 'pending'],
            ['name' => 'Accepted', 'code' => 'accepted'],
            ['name' => 'In Review', 'code' => 'inreview'],
            ['name' => 'Rejected', 'code' => 'rejected'],
            ['name' => 'Completed', 'code' => 'completed'],
            ['name' => 'Declined', 'code' => 'declined'],
            ['name' => 'Success', 'code' => 'success'],
            ['name' => 'In Progress', 'code' => 'inprogress'],
        ];

        foreach ($statuses as $status) {
            DB::table('request_case_statuses')->updateOrInsert(['code' => $status['code']], $status);
        }
    }
}
