<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RequestChargeState extends Model
{
    protected $table = 'request_charge_states';

    protected $fillable = ['name', 'code'];

    // علاقة One to Many مع RequestCase
    public function requestCases()
    {
        return $this->hasMany(RequestCase::class, 'status_id');
    }
}
