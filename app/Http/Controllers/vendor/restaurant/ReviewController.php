<?php

namespace App\Http\Controllers\vendor\restaurant;

use App\Http\Controllers\Controller;
use App\Models\Product_master;
use App\Models\ProductReview;
use App\Models\VendorReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function index(){
        $VendorReview=VendorReview::select('users.*','vendor_review_rating.*','vendor_review_rating.created_at as created_at')
            ->join('users','users.id','user_id')->where('vendor_id', Auth::guard('vendor')->user()->id)
            ->orderBy('vendor_review_rating.id','desc')
            ->paginate(15);
        return view('vendor.restaurant.review.index', compact('VendorReview'));
    }

    public function product_index(){
        $product_ids=Product_master::where('userId',Auth::guard('vendor')->user()->id)->pluck('id');
        if($product_ids=='')
            $product_ids=[];
        $VendorReview=ProductReview::select('products.*','product_review_rating.*','product_review_rating.created_at as created_at','users.name','users.image')
            ->join('products','products.id','product_review_rating.product_id')->join('users','users.id','user_id')
            ->whereIn('product_review_rating.product_id', $product_ids)
            ->orderBy('product_review_rating.id','desc')
            ->paginate(15);
        return view('vendor.restaurant.review.product_index', compact('VendorReview'));
    }
}
