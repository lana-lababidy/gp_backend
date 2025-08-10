<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RequestCaseStatus extends Model
{
    protected $table = 'request_case_statuses';

    protected $fillable = ['name', 'code'];

    // علاقة One to Many مع RequestCase
    public function requestCases()
    {
        return $this->hasMany(RequestCase::class, 'status_id');
    }
}
