<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $fillable=['vendor_id','user_id'];

    public function products()
    {
        return $this->hasMany(CartProduct::class);
    }

    public function addons()
    {
        return $this->hasMany(CartAddon::class);
    }

    public function cart_product_variants()
    {
        return $this->hasManyThrough(CartProductVariant::class, CartProduct::class,'cart_id','cart_product_id','id','id');
    }
}
