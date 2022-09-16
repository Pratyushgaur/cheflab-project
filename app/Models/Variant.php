<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Variant extends Model
{
    use HasFactory;
    use SoftDeletes;
    public $fillable = ['variant_name', 'variant_price', 'product_id'];

    public function product()
    {
        return $this->belongsTo('App\Product_master');
    }

}
