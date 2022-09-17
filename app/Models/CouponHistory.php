<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;



class CouponHistory extends Model  
{
    use HasFactory;
    protected $table ='coupon_history';	
    public $timestamps = false;
}

