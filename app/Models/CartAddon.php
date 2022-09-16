<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartAddon extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function addons()
    {
        return $this->belongsTo(Addons::class);
    }

    public function cart(){
        return $this->belongsTo(Cart::class);
    }
}
