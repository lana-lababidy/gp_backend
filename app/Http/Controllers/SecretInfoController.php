<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SecretInfo;
use Illuminate\Support\Facades\Validator;

class SecretInfoController extends Controller
{
    public function store(Request $request)
    {
        // 1. التحقق من صحة البيانات (Validation)
        $validator = Validator::make($request->all(), [
            'RealName'   => 'required|string|max:255',
            'birthdate'  => 'required|date',
            'email'      => 'required|email|unique:secret_infos,email',
            'gender'     => 'required|in:male,female',
            'city'       => 'required|string|max:100',
            'user_id'    => 'required|exists:users,id',
            'aliasname'  => 'required|string|max:255',
        ]);


        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        // 2. إنشاء سجل جديد
        $secretInfo = SecretInfo::create([
            'RealName' => $request->RealName,
            'birthdate' => $request->birthdate,
            'email' => $request->email,
            'gender' => $request->gender,
            'city' => $request->city,
            'user_id' => $request->user_id,
        ]);

        // 3. إرجاع نتيجة ناجحة
        return response()->json([
            'message' => 'Secret info created successfully',
            'data' => $secretInfo
        ], 201);
    }
    // جلب كل السجلات
    public function index()
    {
        $secretInfos = SecretInfo::all();

        return response()->json([
            'data' => $secretInfos
        ], 200);
    }

    // جلب السجلات حسب المستخدم
    public function getByUser($user_id)
    {
        $secretInfos = SecretInfo::where('user_id', $user_id)->get();

        if ($secretInfos->isEmpty()) {
            return response()->json([
                'message' => 'No secret info found for this user.'
            ], 404);
        }

        return response()->json([
            'data' => $secretInfos
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $secretInfo = SecretInfo::find($id);

        if (!$secretInfo) {
            return response()->json([
                'message' => 'Secret info not found.'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'RealName' => 'sometimes|required|string|max:255',
            // الاسم المستعار  المحافظة 
            'birthdate' => 'sometimes|required|date',
            'email' => 'sometimes|required|email|unique:secret_infos,email,' . $id,
            'gender' => 'sometimes|required|in:male,female,other',
            'city' => 'sometimes|required|string|max:100',
            'user_id' => 'sometimes|required|exists:users,id',
            'aliasname' => 'sometimes|required|string|max:255', 

        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        // نحدّث الحقول اللي أرسلتها فقط
        $secretInfo->update($request->only([
            'RealName',
            'birthdate',
            'email',
            'gender',
            'city',
            'user_id',
            'aliasname'
        ]));

        return response()->json([
            'message' => 'Secret info updated successfully.',
            'data' => $secretInfo
        ], 200);
    }
}
