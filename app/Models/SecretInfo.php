<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SecretInfo extends Model
{
    protected $table = 'secret_infos';


    protected $fillable = [

        'RealName',
        'birthdate',
        'email',
        'gender',
        'city',
        'user_id'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
