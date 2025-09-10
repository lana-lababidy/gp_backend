<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    protected $table = 'wallets';

    use HasFactory;


    // الحقول القابلة للتعبئة (اختياري)
    protected $fillable = [
        'user_id',
        'total_points',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
