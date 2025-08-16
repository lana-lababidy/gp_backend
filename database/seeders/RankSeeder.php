<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Rank;
use App\Models\User;

class RankSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all(); // استخدم بعض المستخدمين الموجودين

        foreach ($users as $user) {
            Rank::create([
                'user_id' => $user->id,
                'total_points' => rand(10, 500), // نقاط عشوائية
            ]);
        }
    }
}

