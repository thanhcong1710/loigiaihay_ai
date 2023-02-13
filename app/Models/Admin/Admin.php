<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use App\Providers\UtilityServiceProvider as u;

class Admin extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users';

    protected $guarded = 'admin';

    protected $fillable = [
        'username', 'email', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public static function getUserInfo(){
        $data = u::first("SELECT username,full_name, coins,coins_free,vip FROM users WHERE id=".Auth::guard('admin')->user()->id);
        return $data;
    }
}