<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderProductVariant extends Model
{
    use HasFactory;
    protected $fillable=['order_product_id', 'variant_id', 'variant_qty', 'variant_name', 'variant_price'];
    public function order_products()
    {
        return $this->belongsTo(OrderProduct::class);
    }

    public function variants()
    {
        return $this->belongsTo(Variant::class);
    }
}
