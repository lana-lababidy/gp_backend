<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CaseStatesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $states = [
            ['name' => 'Pending', 'code' => 1],
            ['name' => 'Completed', 'code' => 2],
            ['name' => 'Declined', 'code' => 3],
            ['name' => 'Success', 'code' => 4],
            ['name' => 'In Progress', 'code' => 5],
        ];

        foreach ($states as $state) {
            DB::table('case_states')->updateOrInsert(['code' => $state['code']], $state);
        }
    }
}
