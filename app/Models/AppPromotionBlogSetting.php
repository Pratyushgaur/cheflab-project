<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppPromotionBlogSetting extends Model
{
    use HasFactory;

    public function app_promotion_blog(){
        $this->belongsTo(AppPromotionBlogs::class,'app_promotion_blog_id','id');
    }
}
