<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    protected $table = 'donations';


    protected $fillable = [
        'quantity',
        'donation_type_id',
        'status_id',
        'user_id',
        'case_c_id',
        'points',
        
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function case()
    {
        return $this->belongsTo(Case_c::class, 'case_c_id'); // غيّر الاسم إذا كان مختلف
    }

    public function donationType()
    {
        return $this->belongsTo(DonationType::class);
    }

    public function status()
    {
        return $this->belongsTo(DonationStatus::class);
    }
    public function gallery()
    {
        return $this->hasMany(Gallery::class, 'donation_id');
    }
}
