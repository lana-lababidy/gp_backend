<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DonationStatus extends Model
{
    protected $table = 'donation_statuses';

    protected $fillable = ['name', 'code'];

    // علاقة One to Many مع جدول التبرعات (donations)
    public function donations()
    {
        return $this->hasMany(Donation::class, 'status_id');
    }
}
