<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Case_c;
use App\Models\Gallery;

class CaseGalleryController extends Controller
{
    public function store(Request $request, $id)
    {
        $case = Case_c::findOrFail($id);

        $validated = $request->validate([
            'image' => 'required|image|max:2048', // 2MB Max
            'caption' => 'nullable|string|max:255',
            'title' => 'nullable|string|max:255'
        ]);

        $path = $request->file('image')->store('cases', 'public');

        $gallery = Gallery::create([
            'case_id' => $case->id,
            'file_path' => $path,
            'media_type' => 'image',
            'caption' => $validated['caption'] ?? null,
            'title' => $validated['title'] ?? null,
        ]);

        return response()->json([
            'message' => 'Image uploaded successfully',
            'data' => $gallery
        ], 201);
    }
}
