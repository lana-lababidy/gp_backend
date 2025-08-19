<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    protected $table = 'galleries';

    protected $fillable = [
        'media_type', 'file_path', 'caption', 'title', 'donation_id', 'case_c_id', 'request_case_id'    ];

    // علاقة Many to One مع Case
    public function case()
    {
        return $this->belongsTo(Case_c::class, 'case_c_id');
    }
    // علاقة مع طلب الحالة (RequestCase)
    public function requestCase()
    {
        return $this->belongsTo(RequestCase::class, 'request_case_id');
    }
    // لو في علاقة مع Donation (حسب ما ذكرت في الـERD)
    public function donation()
    {
        return $this->belongsTo(Donation::class, 'donation_id');
    }
}
