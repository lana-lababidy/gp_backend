<?php

namespace App\Http\Controllers;

use App\Models\Case_c;
use Illuminate\Http\Request;

class CaseController extends Controller
{ public function index()
    {
        // تحميل الحالات مع بيانات الحالة، نوع التبرع، والمستخدم
        $cases = Case_C::with(['state', 'donationType', 'user'])->get();

        return response()->json([
            'status' => 'success',
            'data' => $cases
        ]);
    }

public function show($id)
{
    
    $case = Case_c::find($id);

    if (!$case) {
        return response()->json([
            'status' => 'error',
            'message' => 'Case not found'
        ], 404);
    }

    return response()->json([
        'status' => 'success',
        'data' => $case
    ]);
}


public function store(Request $request)
{
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'goal_amount' => 'required|numeric',
        'states_id' => 'required|exists:case_states,id',
        'donation_type_id' => 'required|exists:donation_types,id',
        'user_id' => 'required|exists:users,id',
    ]);

    $case = Case_c::create($validated);

    return response()->json([
        'status' => 'success',
        'data' => $case
    ], 201);
}

}