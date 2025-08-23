<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RequestGallery extends Model
{
    protected $table = 'request_galleries';

    protected $fillable = [
        'media_type', 'file_path', 'caption', 'title',  'request_case_id'    ];

   
    // علاقة مع طلب الحالة (RequestCase)
    public function requestCase()
    {
        return $this->belongsTo(RequestCase::class, 'request_case_id');
    }
    
}
