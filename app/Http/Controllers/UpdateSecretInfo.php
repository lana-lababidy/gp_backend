<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
class UpdateSecretInfo extends Controller
{
 public function update(Request $request)
    {
        
  // 1. نحصل على Session-Token من هيدر الطلب
        $sessionToken = $request->header('Session-Token');

        // 2. نتحقق من صلاحية الجلسة باستخدام checkRole
        $role = checkRole($sessionToken);

        if ($role === 'plz login to continue') {
            return response()->json(['message' => $role], 401);
        }

        // 3. التحقق من البيانات المطلوبة
               $validated = $request->validate([
            'RealName' => 'required|string|max:255',
            'birthdate' => 'required|date',
            'email' => 'required|email|unique:secret_infos,email,' . Auth::id(), // أو تعديل حسب قاعدة البيانات
            'gender' => 'required|in:male,female,other',
        ]);
        // 4. جلب المستخدم الحالي (Auth::user() يفترض أنه معرف بناءً على توكن الجلسة)
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        // نحصل على SecretInfo المرتبط باليوزر
        $secretInfo = $user->secretInfo;

        if (!$secretInfo) {
            // إذا ما كان موجود ننشئ جديد ونربطه باليوزر
            $secretInfo = $user->secretInfo()->create($validated);
        } else {
            // تحديث البيانات
            $secretInfo->update($validated);
        }

        // نرجع البيانات المحدثة (يمكنك ترجع $user مع علاقة secretInfo)
        return response()->json([
            'user' => $user,
            'secretInfo' => $secretInfo,
                        'role' => $role,  // ممكن ترجع الدور إذا حبيت

        ], 200);
    }
}