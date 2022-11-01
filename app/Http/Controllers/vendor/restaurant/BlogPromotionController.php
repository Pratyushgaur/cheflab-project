<?php

namespace App\Http\Controllers\vendor\restaurant;

use Illuminate\Http\Request;

class BlogPromotionController extends Controller
{
    public function shop_promotion(Request $request)
    {

        return view('vendor.restaurant.blog_promotion.list');
    }

}
