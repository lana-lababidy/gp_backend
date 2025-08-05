<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fqa extends Model
{
    protected $table = 'fqa';

    protected $fillable = [
        'question',
        'answer',
        'order',
    ];
}
