<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\UserResource;

class UserProfileController extends Controller
{
    /**
     * عرض الملف الشخصي للمستخدم الحالي
     */
    public function show()
    {
        return new UserResource(Auth::user());
    }

    /**
     * تعديل الملف الشخصي للمستخدم الحالي
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'username' => 'string|max:255|unique:users,username,' . $user->id,
            'aliasname' => 'nullable|string|max:255',
            'mobile_number' => 'string|max:20|unique:users,mobile_number,' . $user->id,
            'password' => 'nullable|string|min:8',
            'fcm_token' => 'nullable|string',
        ]);

        if (!empty($validated['password'])) {
            $validated['password'] = bcrypt($validated['password']);
        } else {
            unset($validated['password']);
        }

        /** @var \App\Models\User $user */
        $user = Auth::user();
        $user->update($validated);

        return new UserResource($user);
    }
}
