<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Auth;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notification;
// class User extends Model
class User extends Authenticatable

{
    use HasApiTokens, Notifiable;

    protected $table = 'users';

    protected $fillable = [
        'role_id',
        'username',
        'aliasname',
        'mobile_number',
        'password',
        'user_session',
        'fcm_token',
        // 'wallet_id',
        'email',


    ];

    // علاقة One to One مع Wallet
    public function wallet()
    {
        return $this->hasOne(Wallet::class);
    }

    // علاقة One to One مع SecretInfo
    public function secretInfo()
    {
        return $this->hasOne(SecretInfo::class);
    }

    // // علاقة One to Many مع UserRole
    // public function userRoles()
    // {
    //     return $this->hasMany(UserRole::class);
    // }

    // علاقة One to Many مع Session
    public function sessions()
    {
        return $this->hasMany(Session::class);
    }

    // علاقة One to Many مع Notification
    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    // علاقة One to Many مع Case
    public function cases()
    {
        return $this->hasMany(Case_c::class);
    }

    // علاقة One to Many مع RequestCharge
    public function requestCharges()
    {
        return $this->hasMany(RequestCharge::class);
    }

    // علاقة One to Many مع Donation
    public function donations()
    {
        return $this->hasMany(Donation::class);
    }

    // علاقة One to Many مع RequestCase
    public function requestCases()
    {
        return $this->hasMany(RequestCase::class);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_roles', 'user_id', 'role_id');
    }
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }
    public function rank()
    {
        return $this->hasOne(Rank::class);
    }
}
