<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fqa extends Model
{
    protected $table = 'fqas';

    protected $fillable = [
        'question',
        'answer',
        'order',
    ];
}
