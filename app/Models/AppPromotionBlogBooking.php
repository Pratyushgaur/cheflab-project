<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppPromotionBlogBooking extends Model
{
    use HasFactory;

    public function product(){
        return $this->belongsTo(Product_master::class,'product_id','id');
    }
    public function app_promotion_blog(){
        return $this->belongsTo(AppPromotionBlogs::class,'app_promotion_blog_id','id');
    }

    public function app_promotion_setting(){
        return $this->belongsTo(AppPromotionBlogSetting::class,'app_promotion_blog_setting_id','id');
    }
}
