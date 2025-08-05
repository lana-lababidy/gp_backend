<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RequestCharge extends Model
{
    protected $table = 'request_charges';

    protected $fillable = [
        'user_id',
        'amount',
        'states_id',
        'quantity',
    ];

    // علاقة Many to One مع المستخدم (User)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // علاقة Many to One مع حالة طلب الشحن (RequestChargeState)
    public function state()
    {
        return $this->belongsTo(RequestCaseStatus::class, 'states_id');
    }
}
