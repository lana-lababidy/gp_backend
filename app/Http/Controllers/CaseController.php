<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Case_c;
use App\Models\CaseC;

class CaseController extends Controller
{
    public function index()
    {
        // الأكواد التي تمثل التبرعات المقبولة
        $acceptedDonationStatusCodes = [2, 3]; // Accepted, Completed

        // جلب الحالات مع التبرعات وحالة التبرع وحالة الحالة
        $cases = Case_c::with(['state', 'donations.status'])
            ->get();

        $result = [];

        foreach ($cases as $case) {
            // حساب كمية التبرعات المقبولة فقط
            $fulfilledQuantity = $case->donations
                ->filter(fn($donation) => $donation->status && in_array($donation->status->code, $acceptedDonationStatusCodes))
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
