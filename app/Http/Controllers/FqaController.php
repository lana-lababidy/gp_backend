<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Faq;
use App\Models\Fqa;

class FqaController extends Controller
{
    // عرض كل الأسئلة الشائعة مع الإجابات
    public function index()
    {
        // جلب كل الأسئلة مرتبة حسب العمود order (اختياري)
        $faqs = Fqa::orderBy('order', 'asc')->get();

        return response()->json([
            'status' => 'success',
            'data' => $faqs
        ]);
    }

    // إضافة سؤال جديد
    public function store(Request $request)
    {
        $validated = $request->validate([
            'question' => 'required|string',
            'answer' => 'required|string',
            'order' => 'nullable|integer',
        ]);

        $faq = Fqa::create($validated);

        return response()->json([
            'status' => 'success',
            'data' => $faq
        ]);
    }

    // تعديل سؤال موجود
    public function update(Request $request, $id)
    {
        $faq = Fqa::find($id);
        if (!$faq) {
            return response()->json([
                'status' => 'error',
                'message' => 'FAQ not found'
            ], 404);
        }

        $validated = $request->validate([
            'question' => 'sometimes|string',
            'answer' => 'sometimes|string',
            'order' => 'nullable|integer',
        ]);

        $faq->update($validated);

        return response()->json([
            'status' => 'success',
            'data' => $faq
        ]);
    }

    // حذف سؤال
    public function destroy($id)
    {
        $faq = Fqa::find($id);
        if (!$faq) {
            return response()->json([
                'status' => 'error',
                'message' => 'FAQ not found'
            ], 404);
        }

        $faq->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'FAQ deleted successfully'
        ]);
    }
}
