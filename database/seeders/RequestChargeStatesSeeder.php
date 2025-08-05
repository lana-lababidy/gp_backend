<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RequestChargeStatesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $states = [
            ['name' => 'Pending', 'code' => 1],
            ['name' => 'Approved', 'code' => 2],
            ['name' => 'Declined', 'code' => 3],
        ];

        foreach ($states as $state) {
            DB::table('request_charge_states')->updateOrInsert(['code' => $state['code']], $state);
        }
    }
}
