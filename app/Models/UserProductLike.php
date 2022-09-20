<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProductLike extends Model
{
    use HasFactory;

    public $fillable = ['user_id', 'product_id'];
    public $table ='user_product_like';
}
