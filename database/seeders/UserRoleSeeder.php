<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;

class UserRoleSeeder extends Seeder
{
    public function run(): void
    {
        // نحصل على الأدوار
        $adminRole = Role::where('name', 'admin')->first();
        $clientRole = Role::where('name', 'client')->first();

        // نربط أول مستخدم (محمد) بدور admin
        $adminUser = User::where('username', 'محمد')->first();
        if ($adminUser && $adminRole) {
            $adminUser->roles()->syncWithoutDetaching([$adminRole->id]);
        }

        // نربط باقي المستخدمين بدور client
        $clientUsers = User::where('username', '!=', 'محمد')->get();
        foreach ($clientUsers as $user) {
            if ($clientRole) {
                $user->roles()->syncWithoutDetaching([$clientRole->id]);
            }
        }
    }
}
