<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gallery;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    // رفع صورة لمعرض حالة
    public function storeCaseGallery(Request $request, $caseId)
    {
            $request->validate([
                'file' => 'required|file|mimes:jpg,jpeg,png,mp4,pdf|max:5120',
                'title' => 'nullable|string|max:255',
                'caption' => 'nullable|string|max:255',
                'donation_id' => 'nullable|exists:donations,id',
            ]);

            $path = $request->file('file')->store('galleries', 'public');

            $gallery = Gallery::create([
                'case_c_id' => $caseId,
                'donation_id' => $request->donation_id,
                'request_case_id' => null, // <--- مهم
                'media_type' => $request->file('file')->getClientOriginalExtension(),
                'file_path' => $path,
                'title' => $request->title,
                'caption' => $request->caption,
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'تم رفع الملف للمعرض',
                'data' => $gallery
            ]);
         
    }
// رفع صورة لمعرض التبرع
public function storeDonationGallery(Request $request, $donationId)
{
    try{
    $request->validate([
        'file' => 'required|file|mimes:jpg,jpeg,png,mp4,pdf|max:5120',
        'title' => 'nullable|string|max:255',
        'caption' => 'nullable|string|max:255',
    ]);

    $path = $request->file('file')->store('galleries', 'public');

    $gallery = Gallery::create([
        'donation_id' => $donationId,
        'media_type' => $request->file('file')->getClientOriginalExtension(),
        'file_path' => $path,
        'title' => $request->title,
        'caption' => $request->caption,
    ]);

    return response()->json([
        'status' => 'success',
        'message' => 'تم رفع الملف لمعرض التبرع',
        'data' => $gallery
    ]);
}
         catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
}

    // رفع صورة لمعرض طلب حالة
    public function storeRequestGallery(Request $request, $requestId)
    {
        try{
        $request->validate([
            'file' => 'required|file|mimes:jpg,jpeg,png,mp4,pdf|max:5120',
            'title' => 'nullable|string|max:255',
            'caption' => 'nullable|string|max:255',
        ]);

        $path = $request->file('file')->store('galleries', 'public');

        $gallery = Gallery::create([
            'request_case_id' => $requestId,
            'media_type' => $request->file('file')->getClientOriginalExtension(),
            'file_path' => $path,
            'title' => $request->title,
            'caption' => $request->caption,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'تم رفع الملف لمعرض الطلب',
            'data' => $gallery
        ]);
    }
         catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    // عرض معرض الحالة
    public function getCaseGallery($caseId)
    {
        $gallery = Gallery::where('case_c_id', $caseId)->get();

        return response()->json([
            'status' => 'success',
            'data' => $gallery
        ]);
    }

    // عرض معرض طلب الحالة
    public function getRequestGallery($requestId)
    {
        $gallery = Gallery::where('request_case_id', $requestId)->get();

        return response()->json([
            'status' => 'success',
            'data' => $gallery
        ]);
    }

    // عرض معرض التبرع
    public function getDonationGallery($donationId)
    {
        $gallery = Gallery::where('donation_id', $donationId)->get();

        return response()->json([
            'status' => 'success',
            'data' => $gallery
        ]);
    }
}
