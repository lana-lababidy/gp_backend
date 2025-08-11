<?php

namespace App\Http\Controllers;

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

    // POST /api/request-cases
    public function store(Request $request)
    {
        
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'description' => 'required|string',
            'status_id' => 'required|exists:request_case_statuses,id',
            'userName' => 'required|string',
            'email' => 'required|email',
            'mobile_number' => 'required|numeric',
            'importance' => 'required|integer|min:1',
            'case_c_id' => 'required|exists:case_cs,id', // لو بدك تربط بالحالة الأساسية
        ]);

        $newRequestCase = RequestCase::create($validated);

        return response()->json([
            'status' => 'success',
            'data' => $newRequestCase,
        ], 201);
    }
}