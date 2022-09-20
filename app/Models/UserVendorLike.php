<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserVendorLike extends Model
{
    use HasFactory;

    public $fillable = ['user_id', 'vendor_id'];
    public $table ='user_vendor_like';
}
