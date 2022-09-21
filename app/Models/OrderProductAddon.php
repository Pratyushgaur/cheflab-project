<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderProductAddon extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function addons()
    {
        return $this->belongsTo(Addons::class);
    }

    public function order_product(){
        return $this->belongsTo(OrderProduct::class);
    }
}
