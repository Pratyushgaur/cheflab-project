<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Product_master extends Model
{
    use HasFactory;
    protected $primaryKey='id';
    protected $table ='products';
    public $timestamps = false;

    public function product_variants()
    {
        return $this->hasMany(Variant::class,'product_id','id');
    }

    public function cuisines(){
        return $this->belongsTo(Cuisines::class,'cuisines','id');//->select('name','cuisinesImage','position');
    }
}

