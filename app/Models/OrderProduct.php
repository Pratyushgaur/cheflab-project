<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    use HasFactory;

    protected $fillable = ['order_id', 'product_id', 'product_qty', 'product_name', 'product_price'];
    public function product()
    {
        return $this->belongsTo(Product_master::class,'product_id','id');
    }
    public function order()
    {
        return $this->belongsTo(order::class);
    }

    public function order_product_variants(){
        return $this->hasMany(OrderProduct::class);
    }

    public function order_product_addons(){
        return $this->hasMany(OrderProduct::class);
    }
}
