<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Donation;

class DonationController extends Controller
{
    public function store(Request $request)
    {
        // التحقق من البيانات
        $validated = $request->validate([
            'quantity'         => 'required|integer|min:1',
            'donation_type_id' => 'required|exists:donation_types,id',
            'status_id'        => 'required|exists:donation_statuses,id',
            'user_id'          => 'required|exists:users,id',
            'case_c_id'        => 'nullable|exists:case_cs,id', // صار Nullable
        ]);

        // إنشاء التبرع
        $donation = Donation::create([
            'quantity'         => $validated['quantity'],
            'donation_type_id' => $validated['donation_type_id'],
            'status_id'        => $validated['status_id'],
            'user_id'          => $validated['user_id'],
            'case_c_id'        => $validated['case_c_id'] ?? null, // إذا ما انبعت، يظل null
        ]);

        return response()->json([
            'message' => 'تم تسجيل الدعم بنجاح',
            'data'    => $donation
        ], 201);
    }
    // عرض قائمة كل التبرعات (GET /api/donations)
    public function index()
    {
        // تجيب كل التبرعات مع البيانات المرتبطة (مثلاً النوع، الحالة، المستخدم، الحالة المرتبطة)
        $donations = Donation::with(['donationType', 'status', 'user', 'case'])->get();

        return response()->json([
            'message' => 'قائمة التبرعات',
            'data' => $donations
        ]);
    }
    // عرض التبرعات الخاصة بطلب معين (GET /api/requests/{id}/donations)
    public function donationsByRequest($id)
    {
        // نتأكد الطلب موجود
        $request = \App\Models\RequestCase::find($id);
        if (!$request) {
            return response()->json([
                'message' => 'الطلب غير موجود'
            ], 404);
        }

        // نجيب التبرعات المرتبطة بالطلب (حسب case_c_id أو حسب العلاقة)
        $donations = Donation::where('case_c_id', $id)->with(['donationType', 'status', 'user'])->get();

        return response()->json([
            'message' => "التبرعات الخاصة بالطلب رقم {$id}",
            'data' => $donations
        ]);
    }

    // عرض تفاصيل تبرع واحد (GET /api/donations/{id})
public function show($id)
{
    $donation = Donation::with(['donationType', 'status', 'user', 'case'])->find($id);

    if (!$donation) {
        return response()->json([
            'message' => 'التبرع غير موجود'
        ], 404);
    }

    return response()->json([
        'message' => "تفاصيل التبرع رقم {$id}",
        'data' => $donation
    ]);
}

}
