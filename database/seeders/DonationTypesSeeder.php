<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DonationTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        $types = [
            ['name' => 'money', 'code' => 1],
            ['name' => 'in_kind', 'code' => 2],
            ['name' => 'service', 'code' => 3],
        ];

        foreach ($types as $type) {
            DB::table('donation_types')->updateOrInsert(['code' => $type['code']], $type);
        }
    }
}
