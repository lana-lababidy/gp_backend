<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RequestCharge;
use App\Models\Wallet;
use App\Models\RequestChargeState;
use Illuminate\Support\Facades\Auth;

class WalletController extends Controller
{
    // =================== دور المستخدم ===================

    // 1. إرسال طلب شحن المحفظة
    public function requestTopup(Request $request)
    {
        $request->validate([
            'quantity' => 'required|numeric|min:1',
            'amount' => 'required|numeric|min:1'
        ]);

        $pendingState = RequestChargeState::where('name', 'Pending')->first();

        $charge = RequestCharge::create([
            'quantity' => $request->quantity,
            'amount' => $request->amount,
            'user_id' => Auth::id(),
            'status_id' =>  1,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'طلب شحن المحفظة تم بنجاح',
            'request_id' => $charge->id
        ]);
    }

    // 2. عرض تاريخ طلبات الشحن
    public function getTopupHistory(Request $request)
    {
        $query = RequestCharge::where('user_id', Auth::id())->with('status');

        if ($request->has('status')) {
            $status = RequestChargeState::where('name', ucfirst($request->status))->first();
            if ($status) $query->where('status_id', $status->id);
        }

        $requests = $query->get()->map(function($item){
            return [
                'id' => $item->id,
                'quantity' => $item->quantity,
                'amount' => $item->amount,
                'status' => $item->status->name,
                'created_at' => $item->created_at,
            ];
        });

        return response()->json($requests);
    }

    // 3. عرض رصيد المحفظة
    public function getBalance()
    {
        $wallet = Wallet::where('user_id', Auth::id())->first();
        return response()->json([
            'total_points' => $wallet ? $wallet->total_points : 0
        ]);
    }

    // =================== دور الإدمن ===================

    // 4. عرض جميع طلبات الشحن (مع فلترة حسب الحالة)
    public function getAllTopupRequests(Request $request)
    {
        $query = RequestCharge::with('user', 'status');

        if ($request->has('status')) {
            $status = RequestChargeState::where('name', ucfirst($request->status))->first();
            if ($status) $query->where('status_id', $status->id);
        }

        $requests = $query->get()->map(function($item){
            return [
                'id' => $item->id,
                'user_id' => $item->user->id,
                'username' => $item->user->username ?? $item->user->aliasname,
                'quantity' => $item->quantity,
                'amount' => $item->amount,
                'status' => $item->status->name,
                'created_at' => $item->created_at,
            ];
        });

        return response()->json($requests);
    }

    // 5. الموافقة أو الرفض على طلب شحن
    public function processTopupRequest(Request $request)
    {
        $request->validate([
            'request_id' => 'required|exists:request_charges,id',
            'action' => 'required|in:approve,decline'
        ]);

        $charge = RequestCharge::findOrFail($request->request_id);
        $approvedState = RequestChargeState::where('name', 'Approved')->first();
        $declinedState = RequestChargeState::where('name', 'Declined')->first();

        if ($request->action === 'approve') {
            $charge->status_id = $approvedState->id;
            $charge->save();

            $wallet = Wallet::firstOrCreate(
                ['user_id' => $charge->user_id],
                ['total_points' => 0]
            );
            $wallet->total_points += $charge->quantity;
            $wallet->save();

            return response()->json(['success' => true, 'message' => 'تمت الموافقة على طلب الشحن']);
        } else {
            $charge->status_id = $declinedState->id;
            $charge->save();

            return response()->json(['success' => true, 'message' => 'تم رفض طلب الشحن']);
        }
    }

    // 6. عرض رصيد أي مستخدم
    public function getUserBalance($user_id)
    {
        $wallet = Wallet::where('user_id', $user_id)->first();
        return response()->json([
            'user_id' => $user_id,
            'total_points' => $wallet ? $wallet->total_points : 0
        ]);
    }
}
