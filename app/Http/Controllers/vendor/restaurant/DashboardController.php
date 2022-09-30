<?php

namespace App\Http\Controllers\vendor\restaurant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product_master;
use Auth;
class DashboardController extends Controller
{
    public function index()
    {
        $product =  Product_master::where('userId','=',Auth::guard('vendor')->user()->id);
        $product = $product->select('products.product_name','products.id as product_id','product_image','product_price');
        $product = $product->addSelect(\DB::raw('(SELECT IFNULL(COUNT(id),0) as total FROM order_products WHERE  order_products.product_id =  products.id ) AS orderTotal'));
        $product = $product->orderBy('product_rating','DESC')->limit(4)->get();
        
        
        return view('vendor.restaurant.dashboard',compact('product'));
    }
}
