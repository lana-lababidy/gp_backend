<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CaseState extends Model
{
    protected $table = 'case_states';

    protected $fillable = ['name', 'code'];

    // علاقة One to Many: حالة القضية عندها عدة قضايا
    public function cases()
    {
        return $this->hasMany(Case_c::class, 'states_id');
    }
}
