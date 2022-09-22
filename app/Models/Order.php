<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $fillable=['vendor_id', 'user_id', 'customer_name', 'delivery_address', 'order_status', 'total_amount', 'gross_amount', 'net_amount', 'discount_amount', 'coupon_id', 'payment_type', 'payment_status', 'transaction_id', 'payment_string', 'order_time','lat','long','pincode','city'];


    public function products()
    {
        return $this->hasMany(OrderProduct::class);
    }


    public function cart_product_variants()
    {
        return $this->hasManyThrough(OrderProductVariant::class, OrderProduct::class,'order_id','order_product_id','id','id');
    }

    public function order_product_addons()
    {
        return $this->hasManyThrough(OrderProductAddon::class, OrderProduct::class,'order_id','order_product_id','id','id');
    }

    public function order_product_details()
    {
        return $this->belongsToMany(Product_master::class,'order_products','order_id','product_id');
    }

}
