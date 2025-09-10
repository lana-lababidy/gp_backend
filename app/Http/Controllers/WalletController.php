<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Wallet;
use App\Models\RequestCharge;
use App\Models\RequestChargeState;

class WalletController extends Controller
{
    // سعر النقطة بالنسبة لليرة
    private $pointsPerLira = 1 / 1000; // كل 1000 ليرة = 1 نقطة

    // المستخدم يرسل طلب شحن
    public function requestTopup(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1'
        ]);

        $charge = RequestCharge::create([
            'user_id' => $request->user_id ?? 1,
            'amount' => $request->amount,
            'quantity' => 0, // أو أي قيمة مناسبة
            'status_id' => RequestChargeState::where('name', 'Pending')->first()->id
        ]);

        return response()->json([
            'success' => true,
            'message' => 'طلب الشحن تم، في انتظار الموافقة',
            'request_id' => $charge->id
        ]);
    }

    // عرض رصيد المستخدم
    public function getBalance($user_id)
    {
        $wallet = Wallet::where('user_id', $user_id)->first();

        return response()->json([
            'total_points' => $wallet ? $wallet->total_points : 0
        ]);
    }


    // الأدمن يشوف الطلبات Pending
    public function getPendingRequests()
    {
        $pending = RequestCharge::whereHas('status', function ($q) {
            $q->where('name', 'Pending');
        })->with('user')->get();

        return response()->json($pending);
    }

    // الأدمن يوافق أو يرفض طلب الشحن
    public function processRequest(Request $request)
    {
        $request->validate([
            'request_id' => 'required|exists:request_charges,id',
            'action' => 'required|in:approve,decline'
        ]);

        $charge = RequestCharge::findOrFail($request->request_id);

        $approvedState = RequestChargeState::where('name', 'Approved')->first();
        $declinedState = RequestChargeState::where('name', 'Declined')->first();

        if ($request->action === 'approve') {
            DB::transaction(function () use ($charge, $approvedState) {
                $charge->update(['status_id' => $approvedState->id]);

                $wallet = Wallet::firstOrCreate(
                    ['user_id' => $charge->user_id],
                    ['total_points' => 0]
                );

                // تحويل المبلغ إلى نقاط
                $pointsPerLira = 1 / 1000;
                $pointsToAdd = $charge->amount * $pointsPerLira;

                $wallet->increment('total_points', $pointsToAdd);
            });

            return response()->json(['success' => true, 'message' => 'تمت الموافقة وتحديث المحفظة']);
        } else {
            $charge->update(['status_id' => $declinedState->id]);
            return response()->json(['success' => true, 'message' => 'تم رفض الطلب']);
        }
    }
}
