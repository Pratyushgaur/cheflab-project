<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class ProductReview extends Model
{
    use HasFactory,SoftDeletes;
    protected $table ='product_review_rating';	
    public $timestamps = false;
}
