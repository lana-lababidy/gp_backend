<?php

namespace App\Http\Controllers;

use App\Models\Case_c;
use App\Models\RequestCase;
use Illuminate\Http\Request;

class RequestCaseController extends Controller
{
    public function index()
    {
        $requestCases = RequestCase::with(['status', 'user'])->get();

        return response()->json([
            'status' => 'success',
            'data' => $requestCases,
        ]);
    }

    // GET /api/request-cases/{id}
    public function show($id)
    {
        $requestCase = RequestCase::with(['status', 'user'])->find($id);

        if (!$requestCase) {
            return response()->json([
                'status' => 'error',
                'message' => 'Request case not found',
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $requestCase,
        ]);
    }
    //1 المستخدم يضيف طلب حالة
    // POST /api/request-cases
    public function store(Request $request)
    {
        // تحقق من البيانات المرسلة
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'description' => 'required|string',
            'title' => 'required|string', // أضفنا هنا
            'status_id' => 'required|exists:request_case_statuses,id',
            'userName' => 'required|string', //عدلي لتصير المستعار
            'donation_type_id' => 'required|exists:donation_types,id',
            'mobile_number' => 'required|numeric',
            'importance' => 'required|integer|min:1',
            'case_c_id' => 'required|exists:case_cs,id',
            'goal_quantity' => 'nullable|integer|min:0',
            'fulfilled_quantity' => 'nullable|integer|min:0',
            // 'status' => 'nullable|string',
        ]);

        try {
            $requestCase = RequestCase::create([
                'user_id' => $validated['user_id'],
                'title' => $validated['title'],
                'description' => $validated['description'],
                'status_id' => $validated['status_id'],
                'userName' => $validated['userName'],
                'mobile_number' => $validated['mobile_number'],
                'donation_type_id' => $validated['donation_type_id'],
                'importance' => $validated['importance'],
                'case_c_id' => $validated['case_c_id'],
                'goal_quantity' => $validated['goal_quantity'] ?? 0,
                'fulfilled_quantity' => $validated['fulfilled_quantity'] ?? 0,
                'status' => 'pending', 
                // 'status' => $validated['status'] ?? 'pending',
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'تم إرسال الحالة للمراجعة.',
                'data' => $requestCase
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    //2 الادمن يشوف كل الطلبات بانتظار المراجعة
    public function pendingRequests()
    {
        $requests = RequestCase::where('status', 'pending')->get();

        return response()->json([
            'status' => 'success',
            'data' => $requests
        ]);
    }
    // الادمن يقبل الطلب → يتحول إلى Case أساسي
    public function approveRequest($requestCaseId)
    {
        try {
            // 1. جلب الطلب

            $requestCase = RequestCase::findOrFail($requestCaseId);

            if ($requestCase->status !== 'pending') {
                return response()->json([
                    'status' => 'error',
                    'message' => 'هذا الطلب تمت مراجعته مسبقاً.'
                ], 400);
            }
            // 2. حساب النقاط
            $goalAmount = $requestCase->goal_amount ?? 0;           // المبلغ الإجمالي
            $points = intval($goalAmount / 1000);                   // كل 1000 ليرة = نقطة


            // إنشاء نسخة في جدول الحالات الأساسية
            $case = Case_c::create([
                'title' => $requestCase->title,
                'description' => $requestCase->description,
                'goal_amount' => $requestCase->goal_amount ?? 0,
                'points' => $points,
                'user_id' => $requestCase->user_id,
                'states_id' => 1, // حالة أولية "مفتوحة"
                'donation_type_id' => 1, // مؤقت أو حسب المطلوب
            ]);

            // تحديث حالة الطلب
            $requestCase->update(['status' => 'approved']);

            return response()->json([
                'status' => 'success',
                'message' => 'تمت الموافقة على الطلب وإنشاء الحالة الأساسية.',
                'data' => $case
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage() // رسالة الخطأ الحقيقية
            ], 500);
        }
    }

    //4الادمن يرفض الطلب 
    public function rejectRequest($id)
    {
        $requestCase = RequestCase::findOrFail($id);

        $requestCase->update(['status' => 'rejected']);

        return response()->json([
            'status' => 'success',
            'message' => 'تم رفض الطلب.'
        ]);
    }

    // GET /api/request-cases/{id}
    public function progress($id)
    {
        $requestCase = RequestCase::findOrFail($id);

        if ($requestCase->goal_quantity <= 0) {
            return response()->json([
                'message' => 'لم يتم تحديد كمية الهدف لهذا الطلب.',
                'progress' => 0
            ], 400);
        }
        //تقسيم الكمية المُنجزة على الكمية الكاملة المطلوبة. 
        //ضرب النتيجة بـ 100
        $progress = ($requestCase->fulfilled_quantity / $requestCase->goal_quantity) * 100;

        return response()->json([
            'id'                => $requestCase->id,
            'description'       => $requestCase->description,
            'goal_quantity'     => $requestCase->goal_quantity,
            'fulfilled_quantity' => $requestCase->fulfilled_quantity,
            'progress'          => round($progress, 2) . '%'
        ]);
    }
    // PUT /api/request-cases/{id}
    public function update(Request $request, $id)
    {
        $requestCase = RequestCase::find($id);

        if (!$requestCase) {
            return response()->json([
                'status' => 'error',
                'message' => 'Request case not found',
            ], 404);
        }

        $validated = $request->validate([
            'description' => 'sometimes|string',
            'userName' => 'sometimes|string',
            'mobile_number' => 'sometimes|numeric',
            'importance' => 'sometimes|integer|min:1',
            'goal_quantity' => 'sometimes|integer|min:0',
            'fulfilled_quantity' => 'sometimes|integer|min:0',
            'status_id' => 'sometimes|exists:request_case_statuses,id',
            'case_c_id' => 'sometimes|exists:case_cs,id',
            'user_id' => 'sometimes|exists:users,id',
        ]);

        $requestCase->update($validated);

        return response()->json([
            'status' => 'success',
            'data' => $requestCase,
        ]);
    }

    // DELETE /api/request-cases/{id}
    public function destroy($id)
    {
        $requestCase = RequestCase::find($id);

        if (!$requestCase) {
            return response()->json([
                'status' => 'error',
                'message' => 'Request case not found',
            ], 404);
        }

        $requestCase->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Request case deleted successfully',
        ]);
    }
    public function updateStatus(Request $request, $id)
    {
        $requestCase = RequestCase::find($id);

        if (!$requestCase) {
            return response()->json([
                'status' => 'error',
                'message' => 'Request case not found',
            ], 404);
        }

        $validated = $request->validate([
            'status_id' => 'required|exists:request_case_statuses,id'
        ]);

        $requestCase->status_id = $validated['status_id'];
        $requestCase->save();

        return response()->json([
            'status' => 'success',
            'data' => $requestCase,
        ]);
    }
}
