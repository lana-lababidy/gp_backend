<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RequestCase extends Model
{
    protected $table = 'request_cases';
    protected $fillable = [
        'title',
        'user_id',
        'description',
        'status_id',
        'userName',
        // 'email',
        'mobile_number',
        'importance',
        'case_c_id',
        'points',
        'goal_quantity',
        'fulfilled_quantity',
            'status'

    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function status()
    {
        return $this->belongsTo(RequestCaseStatus::class, 'status_id');
    }
    public function galleries()
    {
        return $this->hasMany(RequestGallery::class, 'request_case_id');
    }
}
