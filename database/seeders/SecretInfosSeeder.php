<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SecretInfosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $infos = [
            [
                'RealName' => 'محمد علي',
                'birthdate' => '1990-01-01',
                'email' => 'mohammed@example.com',
                'gender' => 'male',
                'city' => 'دمشق',
                'user_id' => 1,
            ],
            [
                'RealName' => 'محمود حسن',
                'birthdate' => '1992-05-10',
                'email' => 'mahmoud@example.com',
                'gender' => 'male',
                'city' => 'دمشق',

                'user_id' => 2,
            ],
            [
                'RealName' => 'لانا سعاد',
                'birthdate' => '1998-10-23',
                'email' => 'lana@example.com',
                'gender' => 'female',
                'city' => 'حمص',

                'user_id' => 3,
            ],
            [
                'RealName' => 'عمر ناصر',
                'birthdate' => '1988-07-15',
                'email' => 'omar@example.com',
                'gender' => 'male',
                'city' => 'طرطوس',
                'user_id' => 4,
            ],
        ];

        DB::table('secret_infos')->insert($infos);
    }
}
