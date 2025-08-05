<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DonationType extends Model
{
  
    protected $table = 'donation_types';
    protected $fillable = ['name'];

    public function donations()
    {
        return $this->hasMany(Donation::class, 'status_id');
    }
}