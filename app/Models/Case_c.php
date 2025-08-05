<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Case_c extends Model
{

    protected $table = 'case_c';

    public function state()
    {
        return $this->belongsTo(CaseState::class, 'states_id');
    }

    public function donationType()
    {
        return $this->belongsTo(DonationType::class, 'donationType_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function gallery()
    {
        return $this->hasMany(Gallery::class, 'case_id');
    }

    public function donations()
    {
        return $this->hasMany(Donation::class, 'case_id');
    }
}
