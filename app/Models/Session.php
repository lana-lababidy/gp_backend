<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
protected $table = 'sessions';

  protected $fillable = [
        'session_token',
        'user_id',
    ];
    // public function user()
    // {
    //     return $this->belongsTo(User::class);
    // }
    public function user()
{
    return $this->belongsTo(User::class, 'user_id');
}

}
