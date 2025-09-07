<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\RequestCharge;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RequestChargeController extends Controller
{
    /**
     * يوزر يعمل طلب شحن
     */
    public function store(Request $request)
    {

        $request->validate([
            'quantity' => 'required|numeric|min:1',
            'amount' => 'required|numeric|min:1'
        ]);

        // افترض أنك تريد أخذ أول مستخدم Client كمثال
        $user = User::where('role_id', 2)->first(); // 2 = client

        if (!$user) {
            return response()->json(['message' => 'المستخدم غير موجود'], 404);
        }

        $charge = RequestCharge::create([
            'user_id' => $user->id,
            'quantity' => $request->quantity,
            'amount' => $request->amount,
            'status_id' => 1, // pending
        ]);

        return response()->json([
            'message' => 'تم إرسال طلب الشحن بنجاح وهو بانتظار موافقة الأدمن',
            'data' => $charge
        ]);
    }

    /**
     * عرض كل الطلبات (للأدمن)
     */
    public function index()
    {
        $charges = RequestCharge::with('user.wallet')->latest()->get();

        return response()->json($charges);
    }

    /**
     * الأدمن يقبل الطلب
     */
    public function approve($id)
    {
        $charge = RequestCharge::with('user.wallet')->findOrFail($id);

        if (!$charge->user || !$charge->user->wallet) {
            return response()->json(['message' => 'المستخدم أو المحفظة غير موجودة'], 404);
        }

        DB::transaction(function () use ($charge) {
            // تحديث حالة الطلب
            $charge->update(['status_id' => 2]); // 2 = approved

            // تحديث رصيد المحفظة
            $charge->user->wallet->increment('total_points', $charge->amount);
        });

        return response()->json(['message' => 'تمت الموافقة على الطلب وتحديث المحفظة']);
    }

    /**
     * الأدمن يرفض الطلب
     */
    public function reject($id)
    {
        $charge = RequestCharge::findOrFail($id);

        $charge->update(['status_id' => 3]); // 3 = rejected

        return response()->json(['message' => 'تم رفض الطلب']);
    }
}
