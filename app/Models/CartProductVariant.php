<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartProductVariant extends Model
{
    use HasFactory;
    protected $fillable=['cart_product_id', 'variant_id', 'variant_qty'];
    public function cart_products()
    {
        return $this->belongsTo(CartProduct::class);
    }

    public function variants()
    {
        return $this->belongsTo(Variant::class);
    }
}
