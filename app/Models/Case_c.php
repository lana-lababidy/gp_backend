<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Case_c extends Model
{

    protected $table = 'case_cs';
    protected $fillable = ['title', 'description', 'goal_amount', 'states_id', 'donation_type_id', 'user_id'];

    public function state()
    {
        return $this->belongsTo(CaseState::class, 'states_id');
    }

    public function donationType()
    {
        return $this->belongsTo(DonationType::class, 'donation_type_id');

        // return $this->belongsTo(DonationType::class, 'donationType_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');

        // return $this->belongsTo(User::class);
    }

    public function gallery()
    {
        return $this->hasMany(Gallery::class, 'case_c_id');
    }

    public function donations()
    {
        return $this->hasMany(Donation::class, 'case_c_id');
    }
}
//  رررر