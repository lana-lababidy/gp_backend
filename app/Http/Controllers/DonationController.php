<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use Illuminate\Http\Request;

class DonationController extends Controller
{
    public function createDonation(Request $request)
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1',
            'donation_type_id' => 'required|exists:donation_types,id',
            'user_id' => 'required|exists:users,id',
            'case_c_id' => 'required|exists:case_cs,id',
        ]);
        $validated['status_id'] = 1; // حالة Pending دائماً

        $donation = Donation::create($validated);

        return response()->json([
            'success' => true,
            'donation' => $donation,
        ], 201);
    }
    public function updateDonationStatus(Request $request, $id)
    {
        $donation = Donation::findOrFail($id);

        $validated = $request->validate([
            'status_id' => 'required|exists:donation_statuses,id',
        ]);

        $donation->status_id = $validated['status_id'];
        $donation->save();

        return response()->json([
            'success' => true,
            'donation' => $donation,
        ]);
    }
}
