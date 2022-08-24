<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Auth\User as Authenticatable;

class Useradmin extends User
{
    use HasFactory;
    protected $guard = 'admin';
    protected $table = 'superadmin';
    protected $fillable = [
        'name', 'email', 'password',
    ];
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getAdminImageAttribute($value)
    {
        // return  !empty($value)? Storage::url($value) :  url('/')."/commonarea/dist/img/default.png";
        return $url = !empty($value) ? url('/'). Storage::url($value) : '';
    }
}
