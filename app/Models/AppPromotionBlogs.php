<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppPromotionBlogs extends Model
{
    use HasFactory;
    protected $table ='app_promotion_blog';	
    public $timestamps = false;
}
