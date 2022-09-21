<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Order_time extends Model
{
    use HasFactory;//,SoftDeletes;
    protected $table ='vendor_order_time';
    public $timestamps = false;

    public function vendor(){
        $this->belongsTo(vendors::class,'vendor_id','id');
    }
}
