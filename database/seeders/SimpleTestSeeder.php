<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use App\Models\RequestCase;
use App\Models\RequestCaseStatus;
use App\Models\Case_c;
use App\Models\CaseState;
use App\Models\DonationType;

class SimpleTestSeeder extends Seeder
{
    public function run(): void
    {
        // Create basic lookup data
        $adminRole = Role::create(['name' => 'Admin']);
        $userRole = Role::create(['name' => 'User']);

        $pendingStatus = RequestCaseStatus::create([
            'name' => 'Pending Review',
            'code' => 'PENDING'
        ]);

        $activeState = CaseState::create(['name' => 'Active', 'code' => 1]);
        $donationType = DonationType::create(['name' => 'Money', 'code' => 1]);

        // Create test users
        $users = [
            User::create([
                'username' => 'ahmad_hassan',
                'aliasname' => 'أحمد حسن',
                'mobile_number' => '966501234567',
                'password' => bcrypt('password'),
                'role_id' => $userRole->id,
                'email' => 'ahmad@test.com'
            ]),
            User::create([
                'username' => 'fatima_ali',
                'aliasname' => 'فاطمة علي',
                'mobile_number' => '966507654321',
                'password' => bcrypt('password'),
                'role_id' => $userRole->id,
                'email' => 'fatima@test.com'
            ]),
            User::create([
                'username' => 'mohammed_omar',
                'aliasname' => 'محمد عمر',
                'mobile_number' => '966509876543',
                'password' => bcrypt('password'),
                'role_id' => $userRole->id,
                'email' => 'mohammed@test.com'
            ])
        ];

        // Create dummy case for foreign key constraint
        $dummyCase = Case_c::create([
            'title' => 'Dummy Case',
            'description' => 'Dummy case for testing',
            'goal_amount' => 1000,
            'states_id' => $activeState->id,
            'donation_type_id' => $donationType->id,
            'user_id' => $users[0]->id
        ]);

        // Create test request cases with various urgency levels
        $testCases = [
            [
                'title' => 'إصلاح طارئ لسقف المدرسة',
                'description' => 'نحتاج إلى إصلاح عاجل لسقف الفصل الدراسي الرئيسي بسبب التسرب المستمر للمياه خلال فصل الشتاء. هذا يؤثر على سلامة الطلاب وجودة التعليم. الوضع خطير جداً.',
                'userName' => 'مدرسة النور الابتدائية',
                'mobile_number' => 966501111111,
                'importance' => 5,
                'goal_quantity' => 15000,
                'fulfilled_quantity' => 2500, // 16.7% complete
                'user_id' => $users[0]->id
            ],
            [
                'title' => 'Emergency Window Replacement',
                'description' => 'Broken classroom windows pose immediate safety risk to students. Sharp glass fragments everywhere. Need urgent replacement before classes resume tomorrow.',
                'userName' => 'City Elementary School',
                'mobile_number' => 966502222222,
                'importance' => 5,
                'goal_quantity' => 8000,
                'fulfilled_quantity' => 1000, // 12.5% complete
                'user_id' => $users[1]->id
            ],
            [
                'title' => 'تجديد مختبر الحاسوب',
                'description' => 'نحتاج لتحديث أجهزة الحاسوب في المختبر لتحسين تجربة التعلم للطلاب. الأجهزة الحالية قديمة وبطيئة.',
                'userName' => 'مدرسة الأمل المتوسطة',
                'mobile_number' => 966503333333,
                'importance' => 3,
                'goal_quantity' => 25000,
                'fulfilled_quantity' => 12500, // 50% complete
                'user_id' => $users[2]->id
            ],
            [
                'title' => 'Library Book Collection',
                'description' => 'Would like to expand our school library with new educational books for grades 1-6. This will help improve reading skills.',
                'userName' => 'Green Valley Elementary',
                'mobile_number' => 966504444444,
                'importance' => 2,
                'goal_quantity' => 5000,
                'fulfilled_quantity' => 0, // 0% complete
                'user_id' => $users[0]->id
            ],
            [
                'title' => 'إصلاح نظام التدفئة',
                'description' => 'نظام التدفئة في المدرسة معطل والطلاب يعانون من البرد الشديد. نحتاج إصلاح فوري قبل تفاقم المشكلة.',
                'userName' => 'مدرسة الفجر الثانوية',
                'mobile_number' => 966505555555,
                'importance' => 4,
                'goal_quantity' => 10000,
                'fulfilled_quantity' => 3000, // 30% complete
                'user_id' => $users[1]->id
            ],
            [
                'title' => 'Sports Equipment Purchase',
                'description' => 'Need new sports equipment for physical education classes including basketballs, footballs, and exercise mats.',
                'userName' => 'Sunrise High School',
                'mobile_number' => 966506666666,
                'importance' => 2,
                'goal_quantity' => 3000,
                'fulfilled_quantity' => 1500, // 50% complete
                'user_id' => $users[2]->id
            ],
            [
                'title' => 'إصلاح أنابيب المياه المكسورة',
                'description' => 'انفجار في أنابيب المياه الرئيسية يسبب فيضانات في الممرات. الطلاب لا يستطيعون الوصول للفصول بأمان. حالة طوارئ!',
                'userName' => 'مدرسة الرياض الابتدائية',
                'mobile_number' => 966507777777,
                'importance' => 5,
                'goal_quantity' => 12000,
                'fulfilled_quantity' => 0, // 0% complete
                'user_id' => $users[0]->id
            ]
        ];

        foreach ($testCases as $case) {
            RequestCase::create([
                'title' => $case['title'],
                'description' => $case['description'],
                'userName' => $case['userName'],
                'mobile_number' => $case['mobile_number'],
                'importance' => $case['importance'],
                'goal_quantity' => $case['goal_quantity'],
                'fulfilled_quantity' => $case['fulfilled_quantity'],
                'status' => 'pending',
                'status_id' => $pendingStatus->id,
                'case_c_id' => $dummyCase->id,
                'user_id' => $case['user_id']
            ]);
        }

        $this->command->info('Test data seeded successfully!');
        $this->command->info('Created ' . count($testCases) . ' test request cases');
        $this->command->info('Cases range from importance 2-5 with various completion percentages');
    }
}