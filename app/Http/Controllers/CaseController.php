<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Case_c;
use App\Models\CaseC;

class CaseController extends Controller
{
    public function index()
    {

        
        // حالات مقبولة حسب Seeder
        $acceptedCaseStatesCodes = [4, 5]; // Success و In Progress
        $acceptedDonationStatusCodes = [2, 3]; // Accepted و Completed

        $cases = Case_c::with(['state', 'donations.status'])
            ->whereIn('states_id', $acceptedCaseStatesCodes)
            ->get();

        $result = [];

        foreach ($cases as $case) {
            // تحقق إن العلاقة موجودة لتجنب الخطأ NullPointer
            $fulfilledQuantity = $case->donations
                ->filter(function ($donation) use ($acceptedDonationStatusCodes) {
                    return $donation->status && in_array($donation->status->code, $acceptedDonationStatusCodes);
                })
                ->sum('quantity');

            $goalAmount = $case->goal_amount;

            $progress = $goalAmount > 0 ? round(($fulfilledQuantity / $goalAmount) * 100, 2) : 0;

            $result[] = [
                'id' => $case->id,
                'title' => $case->title,
                'description' => $case->description,
                'goal_amount' => $goalAmount,
                'fulfilled_amount' => $fulfilledQuantity,
                'progress_percentage' => $progress,
                'state' => $case->state ? $case->state->name : null,
            ];
        }

        return response()->json([
            'success' => true,
            'data' => $result,
        ]);
    }
}
