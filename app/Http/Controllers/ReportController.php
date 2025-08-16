<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Donation;
use App\Models\RequestCase;

class ReportController extends Controller
{
    public function statistics()
    {
        try {
            $total_users = User::count();
            $total_donations = Donation::count();
            // داخل Controller
            $total_quantity = Donation::sum('quantity'); // صح
            $completed_requests = RequestCase::whereHas('status', function ($q) {
                $q->where('name', 'COMPLETED');
            })->count();

            return response()->json([
                'total_users' => $total_users,
                'total_donations' => $total_donations,
                'total_quantity' => $total_quantity,
                'completed_requests' => $completed_requests
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Internal Server Error',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
