<?php

use App\Models\Orders;
use App\Models\Product_master;
use Carbon\Carbon;
use GuzzleHttp\Client;
use App\Models\OrderCommision;
use App\Models\Paymentsetting;
use App\Models\Vendors;
use App\Models\Vendor_order_statement;
use App\Models\User;
use App\Models\Coupon;
use App\Models\OrderProduct;
function get_product_with_variant_and_addons_v3($product_where = [], $user_id = '', $order_by_column = '', $order_by_order = '', $with_restaurant_name = false, $is_chefleb_product = false, $where_vendor_in = null, $offset = null, $limit = null, $return_total_count = false, $product_ids = null , $serchingKeyword = null)
{
    DB::enableQueryLog();
    //for pagination

    $product = Product_master::where(['products.status' => '1'])
        ->where(['products.product_approve' => '1'])->where(['products.status' => '1']);


    if (!empty($product_where))
        $product->where($product_where);
        
    //    if (!empty($where_vendor_in))
    if ($where_vendor_in != null && is_array($where_vendor_in))
        $product->whereIn('products.userId', $where_vendor_in);
    if ($is_chefleb_product)
        $product->where(['product_for' => '1']);


    if ($return_total_count) {
        $product2 = $product;
        return $product2->count();
    }


    if (!is_null($offset) && !is_null($limit)) {
        $product1 = $product;
        return $product_ids = $product1->offset($offset)->limit($limit)->pluck('id');
        $product->whereIn('products.id', $product_ids);
    }

    if($serchingKeyword !=null){
        $product->where('product_name','like','%' . $serchingKeyword . '%');
    }

    if ($product_ids != null)
        $product->whereIn('products.id', $product_ids);
    if ($with_restaurant_name) {
        $product->join('vendors', 'products.userId', '=', 'vendors.id');
        $product->addSelect('vendors.name as restaurantName', 'vendors.image as vendor_image', 'vendors.profile_image as vendor_profile_image', 'banner_image');
    }

    if ($user_id != '') {
        $product->addSelect(DB::raw('if(user_product_like.user_id is not null, true, false)  as is_like'));

        $product = $product->leftJoin('user_product_like', function ($join) use ($user_id) {
            $join->on('products.id', '=', 'user_product_like.product_id');
            $join->where('user_product_like.user_id', '=', $user_id);
        });
    }
    $product = $product->leftJoin('cart_products', function ($join) use ($user_id) {
        $join->on('products.id', '=', 'cart_products.product_id');
        $join->leftJoin('carts','cart_products.cart_id', '=', 'carts.id');
        $join->where('carts.user_id','=',$user_id);

    });
    if ($order_by_column != '' && $order_by_order != '')
        $product->orderBy($order_by_column, $order_by_order);
    //    dd($product->get()->toArray());
    $qty     = '0';
    $product = $product->addSelect(
        DB::raw('products.userId as vendor_id'),
        'preparation_time',
        'chili_level',
        'type',
        'products.id as product_id',
        'products.product_name',
        'product_price',
        'dis',
        'customizable',
        DB::raw('CONCAT("' . asset('products') . '/", product_image) AS image'),
        'dis as description',
        'products.id as product_id',
        DB::raw('ROUND(product_rating,1) AS product_rating'),
        'primary_variant_name',
        DB::Raw('IFNULL( cart_products.product_qty , 0 ) as cart_qty')
    )->get();
    
    return $product;
}