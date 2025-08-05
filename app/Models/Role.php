<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    protected $table = 'roles';

    protected $fillable = [
        'name',
    ];
    public function userRoles()
    {
        return $this->hasMany(UserRole::class, 'role_id');
    }
public function users()
{
    return $this->belongsToMany(User::class, 'user_roles', 'role_id', 'user_id');
}

}
