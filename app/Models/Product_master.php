<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Product_master extends Model
{
    use HasFactory;
    protected $table ='products';	
    public $timestamps = false;


    
}

