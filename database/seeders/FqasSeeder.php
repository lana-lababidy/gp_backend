<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FqasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fqas = [
            [
                'question' => 'ما هو الهدف من هذا التطبيق؟',
                'answer' => 'يهدف التطبيق إلى تسهيل عمليات التبرع ودعم الحالات التعليمية والاجتماعية.',
                'order' => 1,
            ],
            [
                'question' => 'كيف يمكنني إنشاء حساب؟',
                'answer' => 'يمكنك إنشاء حساب بسهولة عبر صفحة التسجيل باستخدام اسم مستخدم وكلمة مرور.',
                'order' => 2,
            ],
            [
                'question' => 'هل يمكنني التبرع بدون تسجيل؟',
                'answer' => 'لا، يجب تسجيل الدخول لضمان الشفافية وتتبع مساهماتك.',
                'order' => 3,
            ],
            [
                'question' => 'هل التبرعات موثوقة؟',
                'answer' => 'نعم، جميع الحالات موثقة وتخضع للمراجعة من قبل الإدارة قبل نشرها.',
                'order' => 4,
            ],
        ];

        DB::table('fqas')->insert($fqas);
    }
}
