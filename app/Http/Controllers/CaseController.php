<?php

namespace App\Http\Controllers;

use App\Models\Case_c;
use Illuminate\Http\Request;

class CaseController extends Controller
{
public function index(Request $request)
{
    // تحميل الحالات مع بيانات الحالة، نوع التبرع، والمستخدم
    $query = Case_C::with(['state', 'donationType', 'user'])
        ->withSum('donations', 'quantity'); // مجموع التبرعات لكل حالة

    // فلترة حسب نوع التبرع إذا تم إرسال parameter
    if ($request->has('donation_type')) {
        $query->where('donation_type_id', $request->donation_type);
    }

    // البحث بالكلمات إذا تم إرسال parameter search
    if ($request->has('search')) {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->where('title', 'like', "%$search%")
              ->orWhere('description', 'like', "%$search%");
        });
    }

    $cases = $query->get();

    // حساب progress
    $cases->map(function ($case) {
        $case->progress = 0;

        if ($case->goal_amount > 0) {
            $case->progress = round(($case->donations_sum_quantity / $case->goal_amount) * 100, 2);
        }

        return $case;
    });

    return response()->json([
        'status' => 'success',
        'data' => $cases
    ]);
}

    public function show($id)
    {
        $case = Case_c::with(['state', 'donationType', 'user'])
            ->withSum('donations', 'quantity')
            ->find($id);

        if (!$case) {
            return response()->json([
                'status' => 'error',
                'message' => 'Case not found'
            ], 404);
        }

        $case->progress = 0;
        if ($case->goal_amount > 0) {
            $case->progress = round(($case->donations_sum_quantity / $case->goal_amount) * 100, 2);
        }

        return response()->json([
            'status' => 'success',
            'data' => $case
        ]);
    }
     // إنشاء حالة جديدة
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'goal_amount' => 'nullable|numeric|min:0',
            'points' => 'nullable|integer|min:0',
            'user_id' => 'required|exists:users,id',
            'states_id' => 'required|integer',
            'donation_type_id' => 'nullable|integer'
        ]);

        $case = Case_c::create($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Case created successfully',
            'data' => $case
        ], 201);
    }


    // public function show($id)
    // {

    //     $case = Case_c::find($id);

    //     if (!$case) {
    //         return response()->json([
    //             'status' => 'error',
    //             'message' => 'Case not found'
    //         ], 404);
    //     }

    //     return response()->json([
    //         'status' => 'success',
    //         'data' => $case
    //     ]);
    // }


    // public function store(Request $request)
    // {
    //     $validated = $request->validate([
    //         'title' => 'required|string|max:255',
    //         'description' => 'required|string',
    //         'goal_amount' => 'required|numeric',
    //         'states_id' => 'required|exists:case_states,id',
    //         'donation_type_id' => 'required|exists:donation_types,id',
    //         'user_id' => 'required|exists:users,id',
    //     ]);

    //     $case = Case_c::create($validated);

    //     return response()->json([
    //         'status' => 'success',
    //         'data' => $case
    //     ], 201);
    // }
}
