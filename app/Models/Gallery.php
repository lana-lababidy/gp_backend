<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    protected $table = 'gallery';

    protected $fillable = [
        'caption',
        'file_path',
        'media_type',
        'case_id',
        'title',    ];

    // علاقة Many to One مع Case
    public function case()
    {
        return $this->belongsTo(Case_c::class, 'case_id');
    }

    // لو في علاقة مع Donation (حسب ما ذكرت في الـERD)
    public function donation()
    {
        return $this->belongsTo(Donation::class, 'donation_id');
    }
}
