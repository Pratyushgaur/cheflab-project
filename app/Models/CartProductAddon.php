<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartProductAddon extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function addons()
    {
        return $this->belongsTo(Addons::class);
    }

    public function cart_product(){
        return $this->belongsTo(CartProduct::class);
    }
}
