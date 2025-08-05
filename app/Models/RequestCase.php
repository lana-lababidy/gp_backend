<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RequestCase extends Model
{
    protected $table = 'request_cases';
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function status()
    {
        return $this->belongsTo(RequestCaseStatus::class, 'status_id');
    }
}
