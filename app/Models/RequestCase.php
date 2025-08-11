<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RequestCase extends Model
{
    protected $table = 'request_cases';
    protected $fillable = [
    'description',
    'userName',
    'email',
    'mobile_number',
    'importance',
    'status_id',
    'user_id',
    'case_c_id'
];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function status()
    {
        return $this->belongsTo(RequestCaseStatus::class, 'status_id');
    }
}
