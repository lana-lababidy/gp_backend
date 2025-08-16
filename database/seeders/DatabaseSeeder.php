<?php

namespace Database\Seeders;

use App\Models\Cars;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;



class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\U ser::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            CaseStatesSeeder::class,
            DonationStatusesSeeder::class,
            RequestChargeStatesSeeder::class,
            RequestCaseStatusesSeeder::class,
            DonationTypesSeeder::class,
            CaseCsSeeder::class,
            DonationsSeeder::class,
            FqasSeeder::class,
            RequestChargesSeeder::class,
            SecretInfosSeeder::class,
            RequestCasesSeeder::class,
            WalletSeeder::class,
            UserRoleSeeder::class,
            OtpSeeder::class,
TestDataSeeder::class,
RankSeeder::class,


        ]);
    }
}
