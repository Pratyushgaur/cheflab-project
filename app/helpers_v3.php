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
    $product = $product->leftJoin('vendor_offers', function ($join)  {
            $join->on('products.userId', '=', 'vendor_offers.vendor_id');
            $join->whereDate('vendor_offers.from_date','<=',date('Y-m-d'));
            $join->whereDate('vendor_offers.to_date','>=',date('Y-m-d'));
            $join->whereDate('vendor_offers.deleted_at','=',null);
            $join->whereDate('vendor_offers.status','=',"1");
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
        DB::Raw('IFNULL( cart_products.product_qty , 0 ) as cart_qty'),
        "menu_id",
        DB::Raw('IFNULL( vendor_offers.id , 0 ) as offer_id'),
        DB::Raw('IFNULL( vendor_offers.offer_persentage , 0 ) as offer_persentage'),
        DB::raw('
        (CASE 
            WHEN vendor_offers.id IS NOT NULL THEN product_price-product_price/100*vendor_offers.offer_persentage
                ELSE `product_price`
            END) as after_offer_price'
        )

    )->get();
    
    return $product;
}

function get_restaurant_near_me_v3($lat, $lng, $where = [], $current_user_id, $offset = null, $limit = null, $whereVendorIds = [], $alsoClosed = null)
{
    date_default_timezone_set('Asia/Kolkata');
    if ($lat != '' && $lat != ''){
        $vendors = get_restaurant_ids_near_me($lat, $lng, $where, true);
    }else{
        $vendors = \App\Models\Vendors::where("vendors.is_all_setting_done", 1)->where('vendors.status', 1)->where('vendors.is_online', 1);
    }
    $vendors->leftJoin('vendor_order_time', function ($join) {
        $join->on('vendor_order_time.vendor_id', '=', 'vendors.id')
            ->where('vendor_order_time.day_no', '=', Carbon::now()->dayOfWeek)
            //--------------commented, we are sending is open and is_closed
            ->where('start_time', '<=', mysql_time())
            ->where('end_time', '>', mysql_time())
            ->where('available', '=', 1);
    });

    if ($where != null && !empty($where)) {
        $vendors->where($where);
    }

    if ($whereVendorIds != null && !empty($whereVendorIds)) {
        $vendors->whereIn('vendors.id', $whereVendorIds);
    }

    if ($current_user_id != null) {
        $vendors->leftJoin('user_vendor_like', function ($join) use ($current_user_id) {
            $join->on('vendors.id', '=', 'user_vendor_like.vendor_id');
            $join->where('user_vendor_like.user_id', '=', $current_user_id);
        })->addSelect(\DB::raw('if(user_vendor_like.user_id is not null, true, false)  as is_like'));
    }
    $vendors->addSelect(
        'vendor_type',
        'is_all_setting_done',
        'start_time',
        'end_time',
        'vendor_order_time.day_no',
        'vendors.name',
        "vendor_food_type",
        DB::raw('ROUND(vendor_ratings,1) AS vendor_ratings'),
        'vendors.lat',
        'vendors.long',
        'deal_categories',
        \DB::raw('CONCAT("' . asset('vendors') . '/", vendors.image) AS image'),
        DB::raw('if(available,false,true)  as isClosed'),
        "vendors.fssai_lic_no",
        'review_count',
        'table_service',
        'vendors.id as vendor_id',
        'banner_image',
        'deal_cuisines'
    );
    if ($limit != ''){
        $vendors->offset($offset)->limit($limit);
    }

    //    dd($vendors->get()->toArray());
    if ($alsoClosed == null) {
        $vendors->where('available', 1);
    }
    

    return $vendors;
}

function topRatedProducts_v2($lat, $lng, $user_id, $offset, $limit){
    date_default_timezone_set('Asia/Kolkata');
    $select  = "6371 * acos(cos(radians(" . $lat . ")) * cos(radians(vendors.lat)) * cos(radians(vendors.long) - radians(" . $lng . ")) + sin(radians(" . $lat . ")) * sin(radians(vendors.lat))) ";
    $product = Product_master::where(['products.status' => '1','product_for' => '3'])->where(['products.product_approve' => '1']);
    $product->where('products.product_rating', '>', '0');
    $product->join('vendors', 'products.userId', '=', 'vendors.id');
    $product = $product->leftJoin('vendor_order_time', function ($join) {
        $join->on('vendor_order_time.vendor_id', '=', 'vendors.id')
            ->where('vendor_order_time.day_no', '=', Carbon::now()->dayOfWeek)
            //--------------commented, we are sending is open and is_closed
            ->where('start_time', '<=', mysql_time())
            ->where('end_time', '>', mysql_time())
            ->where('available', '=', 1);
    });
    $product = $product->leftJoin('user_product_like', function ($join) use ($user_id) {
        $join->on('products.id', '=', 'user_product_like.product_id');
        $join->where('user_product_like.user_id', '=', $user_id);
    });
    $product->where('available', 1);
    $product->where('vendors.status', '1');
    $product->where('vendors.is_all_setting_done', '1');
    $product->where('vendors.is_online', 1);
    $product->where(DB::raw("ROUND({$select})") ,'<=', config('custom_app_setting.near_by_distance'));
    $product->orderBy('products.product_rating', 'DESC');
    $product->offset($offset)->limit($limit);
    $product = $product->select(
        DB::raw('products.userId as vendor_id'),
        'chili_level',
        'type',
        'products.id as product_id',
        'products.dis as description',
        'products.product_name',
        'product_price',
        'dis',
        'customizable',
        DB::raw('CONCAT("' . asset('products') . '/", product_image) AS image'),
        'dis as description',
        DB::raw('ROUND(product_rating,2) AS product_rating'),
        'primary_variant_name',
        DB::raw('if(user_product_like.user_id is not null, true, false)  as is_like'),
        'preparation_time',
        'vendors.name as restaurantName',
        'menu_id'

    );
    $product = $product->get();
    $cart = \App\Models\Cart::where('user_id', $user_id)->first();
    foreach ($product as $key => $value) {
        $qty = 0;
        if (isset($cart->id) && $cart->id != '') {
            $cart_p = \App\Models\CartProduct::where('cart_id', $cart->id)->where('product_id', $p['product_id'])->selectRaw('SUM(product_qty) as product_qty,id')->groupBy('product_id')->first();
            if (isset($cart_p->product_qty)) {
                $qty          = $cart_p->product_qty;
            }
        }
        $product[$key]->cart_qty = $qty;

    }
    return $product;

}

function mostViewVendors($lat ,$lng ,$userid)
{
    $select  = "6371 * acos(cos(radians(" . $lat . ")) * cos(radians(vendors.lat)) * cos(radians(vendors.long) - radians(" . $lng . ")) + sin(radians(" . $lat . ")) * sin(radians(vendors.lat))) ";
    $vendors = \App\Models\ProfileVisitUsers::where('profile_visit_users.user_id','=',$userid);
    $vendors->join('vendors','profile_visit_users.vendor_id','=','vendors.id');
    $vendors->where("vendors.is_all_setting_done", 1)->where('vendors.status', 1)->where('vendors.is_online', 1);
    $vendors->where(DB::raw("ROUND({$select})") ,'<=', config('custom_app_setting.near_by_distance'));
    $vendors->leftJoin('user_vendor_like', function ($join) use ($userid) {
        $join->on('vendors.id', '=', 'user_vendor_like.vendor_id');
        $join->where('user_vendor_like.user_id', '=', $userid);
    });
    $vendors->leftJoin('vendor_order_time', function ($join) {
        $join->on('vendor_order_time.vendor_id', '=', 'vendors.id')
            ->where('vendor_order_time.day_no', '=', Carbon::now()->dayOfWeek)
            ->where('start_time', '<=', mysql_time())
            ->where('end_time', '>', mysql_time())
            ->where('available', '=', 1);
    });
    $vendors->where('available', 1);
    $vendors->groupBy('profile_visit_users.vendor_id');
    $vendors->orderBy(DB::raw('count(profile_visit_users.id)'),"DESC");
    $vendors->limit(10);

    $vendors->select(
        'vendor_type',
        'start_time',
        'end_time',
        'vendor_order_time.day_no',
        'vendors.name',
        "vendor_food_type",
        DB::raw('ROUND(vendor_ratings,1) AS vendor_ratings'),
        'vendors.lat',
        'vendors.long',
        'deal_categories',
        \DB::raw('CONCAT("' . asset('vendors') . '/", vendors.image) AS image'),
        DB::raw('if(available,false,true)  as isClosed'),
        "vendors.fssai_lic_no",
        'review_count',
        'table_service',
        'vendors.id as vendor_id',
        'banner_image',
        'deal_cuisines',
        \DB::raw('if(user_vendor_like.user_id is not null, true, false)  as is_like'),
        \DB::raw("ROUND({$select}) AS distance")
    );
    return $vendors =  $vendors->get();
    

}