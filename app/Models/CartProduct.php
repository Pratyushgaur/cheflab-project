<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartProduct extends Model
{
    use HasFactory;

    protected $fillable = ['cart_id', 'product_id', 'product_qty'];
    public function product()
    {
        return $this->belongsTo(Product_master::class,'product_id','id');
    }
    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }
}
