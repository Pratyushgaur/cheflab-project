<?php

use App\Models\Orders;
use App\Models\Product_master;
use Carbon\Carbon;
use GuzzleHttp\Client;
use App\Models\OrderCommision;
use App\Models\Paymentsetting;
use App\Models\Vendors;
use App\Models\User;
use App\Models\OrderProduct;

function time_diffrence_in_minutes($datetime1, $datetime2)
{
    $dateTimeObject1 = date_create($datetime1);
    $dateTimeObject2 = date_create($datetime2);

// Calculating the difference between DateTime Objects
    $interval = date_diff($dateTimeObject1, $dateTimeObject2);

// Printing the result in days format


    $min = $interval->days * 24 * 60;
    $min += $interval->h * 60;
    $min += $interval->i;

// Printing the Result in Minutes format.
    return $min;
}

function front_end_short_date_time($datetime)
{
    return date('d-M-y h:i a', strtotime($datetime));
}

function front_end_date_time($datetime)
{
    return date('d F, Y h:i a', strtotime($datetime));
}

function front_end_time($datetime)
{
    return date('h:i a', strtotime($datetime));
}

function front_end_date($datetime)
{
    return date('d F, Y ', strtotime($datetime));
}

function mysql_date_time($datetime = '')
{
    if ($datetime != '')
        return date('Y-m-d H:i:s', strtotime($datetime));
    else
        return date('Y-m-d H:i:s');
}

function mysql_date($datetime = '')
{
    if ($datetime == '')
        return date('Y-m-d');
    else
        return date('Y-m-d', strtotime($datetime));
}

function mysql_time($datetime = '')
{
    if ($datetime != '')
        return date('H:i:s', strtotime($datetime));
    else
        return date('H:i:s');
}

function mysql_date_time_marge($date, $time)
{
    $date_only = date('Y-m-d', strtotime($date));
    $time_only = date('H:i:s', strtotime($time));
    return date('Y-m-d H:i:s', strtotime($date_only . $time_only));
}

function mysql_add_time($datetime, $add_time_minites)
{
    return date('Y-m-d H:i:s', strtotime('+' . $add_time_minites . ' minutes', strtotime($datetime)));
}

function mysql_add_days($datetime, $add_days)
{
    return date('Y-m-d H:i:s', strtotime('+' . $add_days . ' days', strtotime($datetime)));
}

function get_time_ago($time)
{
    $time_difference = time() - $time;

    if ($time_difference < 1) {
        return 'less than 1 second ago';
    }
    $condition = array(
        12 * 30 * 24 * 60 * 60 => 'year',
        30 * 24 * 60 * 60      => 'month',
        24 * 60 * 60           => 'day',
        60 * 60                => 'hour',
        60                     => 'minute',
        1                      => 'second'
    );

    foreach ($condition as $secs => $str) {
        $d = $time_difference / $secs;

        if ($d >= 1) {
            $t = round($d);
            return 'about ' . $t . ' ' . $str . ($t > 1 ? 's' : '') . ' ago';
        }
    }
}

function show_time_slots($start_time, $end_time, $duration, $break)
{

    $time_slots = array();
    $start_time = strtotime($start_time);
    $end_time   = strtotime($end_time);

    $add_mins = $duration * 60;

    while ($start_time <= $end_time) {
        $time_slots[] = date("Y-m-d H:i:s", $start_time);
        $start_time   += $add_mins;
    }

    $time_slots = array_diff($time_slots, $break);

    return $time_slots;
}

function vendorOrderCountByStatus($vendor_id, $status)
{
    if($status=='')
        return Orders::where(['vendor_id' => $vendor_id])->count();

    return Orders::where(['vendor_id' => $vendor_id, 'order_status' => $status])->count();
}

function vendorTodayOrderCount($vendor_id)
{
    return Orders::where(['vendor_id' => $vendor_id])->whereDate('created_at', Carbon::today())->count();
}

function vendorTotalOrderCount($vendor_id)
{
    return Orders::where(['vendor_id' => $vendor_id])->count();
}

function in_between_equal_to($check_number, $from, $to)
{
    return ($from <= $check_number && $check_number <= $to);
}

// function get_product_with_variant_and_addons($product_where = [], $user_id = '', $order_by_column = '', $order_by_order = '', $with_restaurant_name = false, $is_chefleb_product = false, $where_vendor_in = null, $offset = null, $limit = null, $return_total_count = false, $product_ids = null)
// {
//     DB::enableQueryLog();
//     //for pagination

//     $product = Product_master::where(['products.status' => '1'])
//         ->where(['products.product_approve' => '1'])->where(['products.status' => '1']);


//     if (!empty($product_where))
//         $product->where($product_where);

//     //    if (!empty($where_vendor_in))
//     if ($where_vendor_in != null && is_array($where_vendor_in))
//         $product->whereIn('vendors.id', $where_vendor_in);
//     if ($is_chefleb_product)
//         $product->where(['product_for' => '1']);


//     if ($return_total_count) {
//         $product2 = $product;
//         return $product2->count();
//     }


//     if (!is_null($offset) && !is_null($limit)) {

//         $product->offset($offset)->limit($limit);

//     }

//     if ($product_ids != null)
//         $product->whereIn('products.id', $product_ids);
//     if ($with_restaurant_name) {
//         $product->join('vendors', 'products.userId', '=', 'vendors.id');
//         $product->leftJoin('user_vendor_like', function ($join) use ($user_id) {
//             $join->on('vendors.id', '=', 'user_vendor_like.vendor_id');
//             $join->where('user_vendor_like.user_id', '=', $user_id);
//         })->addSelect(\DB::raw('if(user_vendor_like.user_id is not null, true, false)  as is_vendor_like'));
//         $product->addSelect('vendors.name as restaurantName' ,'vendors.image as vendor_image','vendors.profile_image as vendor_profile_image', 'banner_image','review_count', 'deal_cuisines','fssai_lic_no','vendor_food_type','table_service');
//     }


//     $product = $product->join('cuisines', 'products.cuisines', '=', 'cuisines.id');

//     if ($user_id != '') {
//         $product->addSelect('user_product_like.user_id', DB::raw('if(user_product_like.user_id is not null, true, false)  as is_like'));

//         $product = $product->leftJoin('user_product_like', function ($join) use ($user_id) {
//             $join->on('products.id', '=', 'user_product_like.product_id');
//             //$join->where('products.cuisines', '=', 'cuisines.id');
//             //$join->where('products.category', '=', 'categories.id');
//             $join->where('user_product_like.user_id', '=', $user_id);
//         });

//     }

//     $product = $product->leftJoin('variants', 'variants.product_id', 'products.id')
//         ->leftJoin('addons', function ($join) {
//             $join->whereRaw(DB::raw("FIND_IN_SET(addons.id, products.addons)"));
//             $join->whereNull('addons.deleted_at');
//         });
//     $product = $product->orderBy('variants.id', 'ASC');
//     if ($order_by_column != '' && $order_by_order != '')
//         $product->orderBy($order_by_column, $order_by_order);
//     //    dd($product->get()->toArray());
//     $qty     = '0';
//     $product = $product->addSelect(DB::raw('products.userId as vendor_id'),
//         'variants.id as variant_id', 'variants.variant_name', 'variants.variant_price', 'preparation_time', 'chili_level', 'type',
//         'addons.id as addon_id', 'addons.addon', 'addons.price as addon_price',
//         'products.id as product_id', 'products.dis as description', 'products.product_name', 'product_price', 'dis', 'customizable',
//         DB::raw('CONCAT("' . asset('products') . '/", product_image) AS image'), 'cuisines.name as cuisinesName', 'dis as description',
//         'products.id as product_id', 'product_rating','dis','chili_level', 'primary_variant_name')
//         ->get();
//     //dd($product->toArray());
//     //    dd(\DB::getQueryLog());
//     $variant = [];
// //dd($user_id);
//     $cart = \App\Models\Cart::where('user_id', $user_id)->first();
// //    dd($cart);
//     if (count($product->toArray())) {
//         foreach ($product as $i => $p) {
//             $qty = 0;//dd("sdf");
//             if (isset($cart->id) && $cart->id != '') {

//                 $cart_p = \App\Models\CartProduct::where('cart_id', $cart->id)->where('product_id', $p['product_id'])
//                     ->selectRaw('SUM(product_qty) as product_qty')->groupBy('product_id')->get();
//                 if(isset($cart_p[0]->product_qty))
//                     $qty=$cart_p[0]->product_qty;
//             }

//             if (!isset($variant[$p['product_id']])) {
//                 $variant[$p['product_id']] = ['product_id'           => $p['product_id'],
//                                               'product_name'         => $p['product_name'],
//                                               'product_price'        => $p['product_price'],
//                                               'dis'                  => $p['dis'],
//                                               'customizable'         => $p['customizable'],
//                                               'image'                => $p['image'],
//                                               'type'                 => $p['type'],
//                                               'product_rating'       => $p['product_rating'],
//                                               'category'         => $p['categoryName'],
//                                               'is_like'              => $p['is_like'],
//                                               'primary_variant_name' => $p['primary_variant_name'],
//                                               'preparation_time'     => $p['preparation_time'],
//                                               'vendor_id'            => $p['vendor_id'],
//                                               'chili_level'          => $p['chili_level'],
//                                               'cuisines'          => $p['cuisinesName'],
//                                               'categorie'          => $p['categorieName'],
//                                               'cart_qty'             => $qty
//                 ];
//                 if ($with_restaurant_name) {
//                     $variant[$p['product_id']] ['restaurantName'] = $p['restaurantName'];
//                     $variant[$p['product_id']] ['vendor_image'] = asset('vendors') . $p['vendor_image'];
//                     $variant[$p['product_id']] ['review_count'] = $p['review_count'];
//                     $variant[$p['product_id']] ['deal_cuisines'] = $p['deal_cuisines'];
//                     $variant[$p['product_id']] ['fssai_lic_no'] = $p['fssai_lic_no'];
//                     $variant[$p['product_id']] ['vendor_food_type'] = $p['vendor_food_type'];
//                     $variant[$p['product_id']] ['table_service'] = $p['table_service'];

//                     $banners = json_decode($p['banner_image']);

//                     $variant[$p['product_id']] ['cuisines'] = App\Models\Cuisines::whereIn('cuisines.id', explode(',', $p['deal_cuisines']))->pluck('name');
//                     $variant[$p['product_id']]['imageUrl']       = \URL::to('vendor-banner/') . '/';
//                     $variant[$p['product_id']]['next_available'] = next_available_day($p['vendor_id']);
//                     $variant[$p['product_id']]['is_vendor_like'] = $p['is_vendor_like'];

//                     if (is_array($banners))
//                         $variant[$p['product_id']] ['banner_image'] = array_map(function ($banner) {
//                             return URL::to('vendor-banner/') . '/' . $banner;
//                         }, $banners);
//                     else
//                         $variant[$p['product_id']] ['banner_image'] = [];

//                 }


//             }
//             if ($p->variant_id != '') {
//                 $variant[$p['product_id']]['options'][$p->variant_id] = ['id'            => $p->variant_id,
//                                                                          'variant_name'  => $p->variant_name,
//                                                                          'variant_price' => $p->variant_price];
//             }
//             if ($p->addon_id != '')
//                 $variant[$p['product_id']]['addons'][$p->addon_id] = ['id'    => $p->addon_id,
//                                                                       'addon' => $p->addon,
//                                                                       'price' => $p->addon_price];
//         }
//     }
//     foreach ($variant as $i => $v) {
//         if (isset($variant[$i]['options']))
//             $variant[$i]['options'] = array_values($variant[$i]['options']);
//         if (isset($variant[$i]['addons']))
//             $variant[$i]['addons'] = array_values($variant[$i]['addons']);
//     }
//     $product = array_values($variant);
//     //dd($product);
//     return $product;
// }
//
function get_product_with_variant_and_addons($product_where = [], $user_id = '', $order_by_column = '', $order_by_order = '', $with_restaurant_name = false, $is_chefleb_product = false, $where_vendor_in = null, $offset = null, $limit = null, $return_total_count = false, $product_ids = null)
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

    if ($product_ids != null)
        $product->whereIn('products.id', $product_ids);
    if ($with_restaurant_name) {
        $product->join('vendors', 'products.userId', '=', 'vendors.id');
        $product->addSelect('vendors.name as restaurantName', 'vendors.image as vendor_image', 'vendors.profile_image as vendor_profile_image', 'banner_image');
    }


    //$product = $product->join('cuisines', 'products.cuisines', '=', 'cuisines.id');

    if ($user_id != '') {
        $product->addSelect('user_id', DB::raw('if(user_product_like.user_id is not null, true, false)  as is_like'));

        $product = $product->leftJoin('user_product_like', function ($join) use ($user_id) {
            $join->on('products.id', '=', 'user_product_like.product_id');
            //$join->where('products.cuisines', '=', 'cuisines.id');
            //$join->where('products.category', '=', 'categories.id');
            $join->where('user_product_like.user_id', '=', $user_id);
        });

    }

    $product = $product->leftJoin('variants', 'variants.product_id', 'products.id')
        ->leftJoin('addons', function ($join) {
            $join->whereRaw(DB::raw("FIND_IN_SET(addons.id, products.addons)"));
            $join->whereNull('addons.deleted_at');
        });
    $product = $product->orderBy('variants.id', 'ASC');
    if ($order_by_column != '' && $order_by_order != '')
        $product->orderBy($order_by_column, $order_by_order);
    //    dd($product->get()->toArray());
    $qty     = '0';
    $product = $product->addSelect(DB::raw('products.userId as vendor_id'),
        'variants.id as variant_id', 'variants.variant_name', 'variants.variant_price', 'preparation_time', 'chili_level', 'type',
        'addons.id as addon_id', 'addons.addon', 'addons.price as addon_price',
        'products.id as product_id', 'products.dis as description', 'products.product_name', 'product_price', 'dis', 'customizable',
        DB::raw('CONCAT("' . asset('products') . '/", product_image) AS image'), 'dis as description',
        'products.id as product_id', 'product_rating', 'dis', 'chili_level', 'primary_variant_name')
        ->get();
    //dd($product->toArray());
    //    dd(\DB::getQueryLog());
    $variant = [];
//dd($user_id);
    $cart = \App\Models\Cart::where('user_id', $user_id)->first();
//    dd($cart);
    if (count($product->toArray())) {
        foreach ($product as $i => $p) {
            $qty = 0;//dd("sdf");
            if (isset($cart->id) && $cart->id != '') {

                $cart_p = \App\Models\CartProduct::where('cart_id', $cart->id)->where('product_id', $p['product_id'])
                    ->selectRaw('SUM(product_qty) as product_qty,id')->groupBy('product_id')->first();
                if (isset($cart_p->product_qty)) {
                    $qty          = $cart_p->product_qty;
                    $cart_variant = \App\Models\CartProductVariant::where('cart_product_id', $cart_p->id)->pluck('variant_qty', 'variant_id');
                    $cart_addons  = \App\Models\CartProductAddon::where('cart_product_id', $cart_p->id)->pluck('addon_qty', 'addon_id');
                }

            }

            if (!isset($variant[$p['product_id']])) {
                $variant[$p['product_id']] = ['product_id'           => $p['product_id'],
                                              'product_name'         => $p['product_name'],
                                              'product_price'        => $p['product_price'],
                                              'dis'                  => $p['dis'],
                                              'customizable'         => $p['customizable'],
                                              'image'                => $p['image'],
                                              'type'                 => $p['type'],
                                              'product_rating'       => $p['product_rating'],
                                              'category'             => $p['categoryName'],
                                              'is_like'              => $p['is_like'],
                                              'primary_variant_name' => $p['primary_variant_name'],
                                              'preparation_time'     => $p['preparation_time'],
                                              'vendor_id'            => $p['vendor_id'],
                                              'chili_level'          => $p['chili_level'],
                                              'cuisines'             => $p['cuisinesName'],
                                              'categorie'            => $p['categorieName'],
                                              'cart_qty'             => $qty
                ];
                if ($with_restaurant_name) {
                    $variant[$p['product_id']] ['restaurantName'] = $p['restaurantName'];
                    //  $variant[$p['product_id']] ['fssai_lic_no'] = $p['fssai_lic_no'];
                    // $variant[$p['product_id']] ['tax'] = $p['tax'];
                    $variant[$p['product_id']] ['vendor_image'] = asset('vendors') . '/' . $p['vendor_image'];

                    $banners = json_decode($p['banner_image']);

                    if (is_array($banners))
                        $variant[$p['product_id']] ['banner_image'] = array_map(function ($banner) {
                            return URL::to('vendor-banner/') . '/' . $banner;
                        }, $banners);
                    else
                        $variant[$p['product_id']] ['banner_image'] = [];

                }


            }
            if ($p->variant_id != '') {
                $v_qty = 0;
                if (isset($cart_variant[$p->variant_id]))
                    $v_qty = $cart_variant[$p->variant_id];
                $variant[$p['product_id']]['options'][$p->variant_id] = ['id'               => $p->variant_id,
                                                                         'variant_name'     => $p->variant_name,
                                                                         'variant_price'    => $p->variant_price,
                                                                         'cart_variant_qty' => $v_qty];
            }
            if ($p->addon_id != '') {
                $a_qty = 0;
                if (isset($cart_addons[$p->addon_id]))
                    $a_qty = $cart_addons[$p->addon_id];

                $variant[$p['product_id']]['addons'][$p->addon_id] = ['id'             => $p->addon_id,
                                                                      'addon'          => $p->addon,
                                                                      'price'          => $p->addon_price,
                                                                      "cart_addon_qty" => $a_qty];
            }
        }
    }
    foreach ($variant as $i => $v) {
        if (isset($variant[$i]['options']))
            $variant[$i]['options'] = array_values($variant[$i]['options']);
        if (isset($variant[$i]['addons']))
            $variant[$i]['addons'] = array_values($variant[$i]['addons']);
    }
    $product = array_values($variant);
    //dd($product);
    return $product;
}

function get_restaurant_ids_near_me($lat, $lng, $where = [], $return_query_object = false, $offset = null, $limit = null, $group_by = true)
{

   // $select  = "( 3959 * acos( cos( radians($lat) ) * cos( radians( vendors.lat ) ) * cos( radians( vendors.long ) - radians($lng) ) + sin( radians($lat) ) * sin( radians( vendors.lat ) ) ) ) ";
    $select  = "6371 * acos(cos(radians(" . $lat . ")) * cos(radians(vendors.lat)) * cos(radians(vendors.long) - radians(" . $lng . ")) + sin(radians(" .$lat. ")) * sin(radians(vendors.lat))) ";
    $vendors = \App\Models\Vendors::where(['vendors.status' => '1', 'is_all_setting_done' => '1']);
    //$vendors = $vendors->selectRaw("ROUND({$select},1) AS distance")->addSelect("vendors.id");
    $vendors = $vendors->selectRaw("ROUND({$select}) AS distance")->addSelect("vendors.id");
    $vendors->having('distance', '<=', config('custom_app_setting.near_by_distance'));
    $vendors->where("vendors.is_all_setting_done", 1)
        ->where('vendors.status', 1)->where('vendors.is_online', 1);
    if ($group_by)
        $vendors->join('products as p', 'p.userId', '=', 'vendors.id')->addSelect('p.userId', DB::raw('COUNT(*) as product_count'))->groupBy('p.userId')->having('product_count', '>', 0);

    if (empty($where))
        $vendors->where($where);
    if ($return_query_object) {
        if ($offset != null && $limit != null)
            return $vendors->offset($offset)->limit($limit);
        else
            return $vendors;
    } else
        return $vendors->orderBy('vendors.id', 'desc')->pluck('id');


}

function front_end_currency($number)
{
//    setlocale(LC_MONETARY, 'en_IN');
//    $amount = money_format('%!i', $number);
//    return "$amount \20B9;";
    $decimal   = (string)($number - floor($number));
    $money     = floor($number);
    $length    = strlen($money);
    $delimiter = '';
    $money     = strrev($money);

    for ($i = 0; $i < $length; $i++) {
        if (($i == 3 || ($i > 3 && ($i - 1) % 2 == 0)) && $i != $length) {
            $delimiter .= ',';
        }
        $delimiter .= $money[$i];
    }

    $result  = strrev($delimiter);
    $decimal = preg_replace("/0\./i", ".", $decimal);
    $decimal = substr($decimal, 0, 3);

    if ($decimal != '0') {
        $result = $result . $decimal;
    }

    return $result . '  &#8377; ';
}

function get_delivery_boy_near_me($lat, $lng,$order)
{
    if ($order->user_id == 4) {
        return \App\Models\Deliver_boy::where('id','=',2)->first();
    } else {
        return \App\Models\Deliver_boy::where('id','=',1)->first();
    }
       
    
}

// function get_restaurant_near_me($lat, $lng, $where = [], $current_user_id, $offset = null, $limit = null)
// {
//     date_default_timezone_set('Asia/Kolkata');
//     if ($lat != '' && $lat != '')
//         $vendors = get_restaurant_ids_near_me($lat, $lng, $where, true);
//     else
//         $vendors=\App\Models\Vendors::where("vendors.is_all_setting_done", 1)->where('vendors.status', 1);

//     $vendors->leftJoin('vendor_order_time', function ($join) {
//         $join->on('vendor_order_time.vendor_id', '=', 'vendors.id')
//             ->where('vendor_order_time.day_no', '=', Carbon::now()->dayOfWeek)
//             //--------------commented, we are sending is open and is_closed
// //            ->where('start_time', '<=', mysql_time())
// //            ->where('end_time', '>', mysql_time())
//             ->where('available', '=', 1);
//     });

//     if ($where != null && !empty($where)) {
//         $vendors->where($where);
//     }

//     if ($current_user_id != null) {
//         $vendors->leftJoin('user_vendor_like', function ($join) use ($current_user_id) {
//             $join->on('vendors.id', '=', 'user_vendor_like.vendor_id');
//             $join->where('user_vendor_like.user_id', '=', $current_user_id);
//         })->addSelect(\DB::raw('if(user_vendor_like.user_id is not null, true, false)  as is_like'));
//     }
//     $vendors->addSelect('vendor_type', 'is_all_setting_done', 'start_time', 'end_time', 'vendor_order_time.day_no', 'vendors.name', "vendor_food_type",
//         'vendor_ratings', 'vendors.lat', 'vendors.long', 'deal_categories',
//         \DB::raw('CONCAT("' . asset('vendors') . '/", vendors.image) AS image'),
//         DB::raw('if(available,false,true)  as isClosed'),
//         "vendors.fssai_lic_no", 'review_count', 'table_service','vendor_order_time.vendor_id','banner_image','deal_cuisines');

//     if (!empty($limit) && !empty($offset))
//         $vendors->offset($offset)->limit($limit);

// //    dd($vendors->get()->toArray());
//     return $vendors;

// }
function get_restaurant_near_me($lat, $lng, $where = [], $current_user_id, $offset = null, $limit = null, $whereVendorIds = [] ,$alsoClosed =null)
{
    date_default_timezone_set('Asia/Kolkata');
    if ($lat != '' && $lat != '')
        $vendors = get_restaurant_ids_near_me($lat, $lng, $where, true);
    else
        $vendors = \App\Models\Vendors::where("vendors.is_all_setting_done", 1)->where('vendors.status', 1);

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

    if($whereVendorIds != null && !empty($whereVendorIds)){
        $vendors->whereIn('vendors.id',$whereVendorIds);
    }

    if ($current_user_id != null) {
        $vendors->leftJoin('user_vendor_like', function ($join) use ($current_user_id) {
            $join->on('vendors.id', '=', 'user_vendor_like.vendor_id');
            $join->where('user_vendor_like.user_id', '=', $current_user_id);
        })->addSelect(\DB::raw('if(user_vendor_like.user_id is not null, true, false)  as is_like'));
    }
    $vendors->addSelect('vendor_type', 'is_all_setting_done', 'start_time', 'end_time', 'vendor_order_time.day_no', 'vendors.name', "vendor_food_type",
        'vendor_ratings', 'vendors.lat', 'vendors.long', 'deal_categories',
        \DB::raw('CONCAT("' . asset('vendors') . '/", vendors.image) AS image'),
        DB::raw('if(available,false,true)  as isClosed'),
        "vendors.fssai_lic_no", 'review_count', 'table_service', 'vendors.id as vendor_id', 'banner_image', 'deal_cuisines');

    if (!empty($limit) && !empty($offset))
        $vendors->offset($offset)->limit($limit);

//    dd($vendors->get()->toArray());
    if($alsoClosed == null){
        $vendors->where('available',1);
    }
    
    
    return $vendors;

}

function next_available_day($vendor_id, $return_obj = false)
{
    //return $vendor_id;
    if($vendor_id==null)return false;
    $today = \Carbon\Carbon::now()->dayOfWeek;
    ///return $today;
    //$today = 3;
     $next_available_day = \App\Models\VendorOrderTime::where('day_no', '=', $today)->where('start_time','>',mysql_time())->where('vendor_id','=',$vendor_id)->orderBy('start_time','ASC')->first();
    if (!isset($next_available_day->id)){
        $exit = 'false';
        while ($exit == 'false') {
            $today++;
            if($today > 6){
              $today=0;
            }

            $next_available_day = \App\Models\VendorOrderTime::where('day_no', '=', $today)->where('available', 1)->where('vendor_id','=',$vendor_id)->orderBy('start_time','ASC')->first();
            if(!empty($next_available_day)){
                $exit = 'true';
            } else {
                $exit = 'false';
            }
        }
    }

//    $today=6;
    //return \App\Models\VendorOrderTime::where('day_no', '=', $today)->where('vendor_id','=',$vendor_id)->orderBy('start_time','ASC')->get();
    // if ($today == 6){
    //     $next_available_day = \App\Models\VendorOrderTime::where('day_no', '>=', 0)->where('vendor_id','=',$vendor_id)->where('available', 1)->orderBy('day_no')->orderBy('start_time','ASC')->first();
    // }

    // else{
    //     return $next_available_day = \App\Models\VendorOrderTime::where('day_no', '=', $today)->where('start_time','>',mysql_time())->where('vendor_id','=',$vendor_id)->orderBy('start_time','ASC')->toSql();
    // }

    //$next_available_day = \App\Models\VendorOrderTime::where('day_no', '>=', $today)->where('available', 1)->orderBy('day_no')->first();

    // if (!isset($next_available_day->id)){

    //     while ($exit == 'false') {
    //         $today++;
    //         if($today == 6) $today=0;
    //         $next_available_day = \App\Models\VendorOrderTime::where('day_no', '=', $today)->where('available', 1)->where('vendor_id','=',$vendor_id)->orderBy('start_time','ASC')->first();
    //         if(!empty($next_available_day)){
    //             $exit = 'true';
    //         }else{
    //             $exit = 'false';
    //         }
    //     }
    // }


    // $next_available_day = \App\Models\VendorOrderTime::where('day_no', '>=', 0)->where('available', 1)->orderBy('day_no')->first();
    if (isset($next_available_day->id))
        if ($return_obj)
            return $next_available_day;
        else {
            $days[0] = "sunday";
            $days[1] = "monday";
            $days[2] = "tuesday";
            $days[3] = "wednesday";
            $days[4] = "thursday";
            $days[5] = "friday";
            $days[6] = "saturday";

            return $days[$next_available_day->day_no] . ' at ' . front_end_time($next_available_day->start_time);
        }
    else
        return null;

}


function get_restaurant_filerty_nonveg($lat, $lng, $where = [], $current_user_id)
{
    date_default_timezone_set('Asia/Kolkata');
    $vendors = get_restaurant_ids_near_me($lat, $lng, $where, true);

    $vendors->addSelect('vendors.id', 'name', "vendor_food_type", 'vendor_ratings', 'lat', 'long', 'deal_categories',
        \DB::raw('CONCAT("' . asset('vendors') . '/", image) AS image'),
        \DB::raw('CONCAT("' . asset('vendors-banner') . '/", banner_image) AS banner_image'),
        DB::raw('if(available,false,true)  as isClosed'),
        \DB::raw('if(user_vendor_like.user_id is not null, true, false)  as is_like')
    )
        ->where('vendor_food_type', '=', '3')
        ->leftJoin('vendor_order_time', function ($join) {
            $join->on('vendor_order_time.vendor_id', '=', 'vendors.id')
                ->where('vendor_order_time.day_no', '=', Carbon::now()->dayOfWeek)
                ->where('start_time', '<=', mysql_time())
                ->where('end_time', '>', mysql_time())->where('available', '=', 1);
        })
        ->leftJoin('user_vendor_like', function ($join) use ($current_user_id) {
            $join->on('vendors.id', '=', 'user_vendor_like.vendor_id');
            $join->where('user_vendor_like.user_id', '=', $current_user_id);
        });

    if (!empty($limit) && !empty($offset))
        $vendors->offset($offset)->limit($limit);

    return $vendors;

}

function generateDriverUniqueCode()
{
    $number = rand(1000000000, 9999999999);
    if (\App\Models\Deliver_boy::where('username', '=', $number)->exists()) {
        $number = rand(1000000000, 9999999999);
    }
    return $number;
}

function point2point_distance($lat1, $lon1, $lat2, $lon2, $unit = 'K')
{
    $theta = $lon1 - $lon2;
    $dist  = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
    $dist  = acos($dist);
    $dist  = rad2deg($dist);
    $miles = $dist * 60 * 1.1515;
    $unit  = strtoupper($unit);

    if ($unit == "K") {
        return ($miles * 1.609344);
    } else if ($unit == "N") {
        return ($miles * 0.8684);
    } else {
        return $miles;
    }
}

function getDrivingDistance($lat1, $long1, $lat2, $long2)
{
    $key = env('GOOGLE_MAPS_API_KEY');
    $url = "https://maps.googleapis.com/maps/api/distancematrix/json?origins=" . $lat1 . "," . $long1 . "&destinations=" . $lat2 . "," . $long2 . "&mode=driving&language=pl-PL&key=$key";
    $client = new Client();
    $response = $client->request('GET', $url);
    $d = $response->getBody();
    $response_a = json_decode($d, true);
    $dist       = $response_a['rows'][0]['elements'][0]['distance']['text'];
    $time       = $response_a['rows'][0]['elements'][0]['duration']['text'];
    $dist       = str_replace(',', '.', $dist);
    return $dist = str_replace('km', '', $dist);
    return array('distance' => $dist, 'time' => $time);
}

function getOrderId()
{
    $order = \App\Models\Order::orderBy('id', 'DESC');
    if ($order->exists()) {
        $id = $order->first()->id;
    } else {
        $id = 0;
    }
    return str_pad(1 + $id, 8, "0", STR_PAD_LEFT);
}

function userToVendorDeliveryCharge($userLat, $userLng, $vendorLat, $vendorLng)
{
    $distance = getDrivingDistance($userLat, $userLng, $vendorLat, $vendorLng);
    //$distance = 3.9;
    $distance = floatval($distance);
    //$distance = 10;
    $setting = App\Models\DeliveryboySetting::first();
    $charge  = $setting->first_three_km_charge_user; // 30
    if ($distance > 3) {
        $remainingkm = $distance - 3.0;
        if ($remainingkm >= 3) {
            $secondCharge = 3 * $setting->three_km_to_six_user;
        } else {
            $secondCharge = $remainingkm * $setting->three_km_to_six_user;
        }
        $charge = $charge + $secondCharge;
        //
        $remainingkm = $remainingkm - 3.0;

        if ($remainingkm > 0) {
            $thirdCharge = $remainingkm * $setting->six_km_above_user;
            $charge      = $charge + $thirdCharge;
        }

    }
    if ($setting->extra_charge_active) {
        $charge = $charge + $setting->extra_charges_user;
    }
    return round($charge);

}
// function sendNotification($title,$body,$token,$data=null,$sound='default'){
//         $url = "https://fcm.googleapis.com/fcm/send";
//         //$token = "ekElJ6_hR9ez2Y9PDIm5SX:APA91bFrhilpGDE1KEB4QlXSYGQ04dYbz-aB6G8A7F5Fsaw5DnHUVL6ttcewpOyvHRM2Uih2lk4TXmk-DiZfotrLGkfRxN2VFVPjn_8BpvNIFopRnJrEQfyJLGo6O_7J7MFX0u4SYGlY";
//         $serverKey = env('FIREBASE_DRIVER_SERVER_KEY');
//         //$title = "Notification title";
//         //$body = "Hello I am from Your php server";
//         $notification = array('title' =>$title , 'body' => $body, 'sound' => $sound, 'badge' => '1',"android_channel_id" =>"ChefLab_Delivery");
//         $arrayToSend = array('registration_ids' => $token, 'notification' => $notification,'priority'=>'high','data'=>$data);
//         $json = json_encode($arrayToSend);
//         $headers = array();
//         $headers[] = 'Content-Type: application/json';
//         $headers[] = 'Authorization: key='. $serverKey;
//         $ch = curl_init();
//         curl_setopt($ch, CURLOPT_URL, $url);
//         curl_setopt($ch, CURLOPT_CUSTOMREQUEST,"POST");
//         curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
//         curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);
//         //Send the request
//          $response = curl_exec($ch);
//         //Close request
//         if ($response === FALSE) {
//         die('FCM Send Error: ' . curl_error($ch));
//         }
//         curl_close($ch);
//         return true;
// }

function sendNotification($title,$body,$token,$data=null,$sound='default')
{
    $server_key = env('FIREBASE_SERVER_KEY');
    // $headers = [
    //     'Authorization' => 'key='.$server_key,
    //     'Content-Type'  => 'application/json',
    // ];
    $url = "https://fcm.googleapis.com/fcm/send";
    $notification = array('title' =>$title , 'body' => $body, 'sound' => $sound, 'badge' => '1',"android_channel_id" =>"ChefLab_Delivery");
    $arrayToSend = array('registration_ids' => $token, 'notification' => $notification,'priority'=>'high','data'=>$data);
    $fields = json_encode ( $arrayToSend );
    // $client = new Client();
    // try{
    //     $request = $client->post($url,[
    //         'headers' => $headers,
    //         "body" => $fields,
    //     ]);
    //     //$response = $request->getBody()->getContents();
    //     $response = (string) $request->getBody()->getContents();
    //     return $response =json_decode($response); 
    //     //return $response;
    // }
    // catch (Exception $e){
    //     return $e;
    // }//
        $json = json_encode($arrayToSend);
        $headers = array();
        $headers[] = 'Content-Type: application/json';
        $headers[] = 'Authorization: key='. $server_key;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST,"POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);
        //Send the request
         return $response = curl_exec($ch);
        //Close request
        if ($response === FALSE) {
        die('FCM Send Error: ' . curl_error($ch));
        }
        curl_close($ch);
        return true;
}

function sendUserAppNotification($title,$body,$token,$data=null){
    $tokens[] = $token;
    
    $server_key = env('FIREBASE_SERVER_KEY');
    $headers = [
        'Authorization' => 'key='.$server_key,
        'Content-Type'  => 'application/json',
    ];
    $url = "https://fcm.googleapis.com/fcm/send";
    $notification = array('title' =>$title , 'body' => $body, 'sound' => 'notify_sound', 'badge' => '1',"android_channel_id" =>"ChefLab_Delivery");
    $arrayToSend = array('registration_ids' => $tokens, 'notification' => $notification,'priority'=>'high','data'=>$data);
    $fields = json_encode ( $arrayToSend );
    $client = new Client();
    try{
        $request = $client->post($url,[
            'headers' => $headers,
            "body" => $fields,
        ]);
        $response = $request->getBody();
        //return $response;
    }
    catch (Exception $e){
        return $e;
    }
    
}


function get_order_preparation_time($order_id)
{
    return \App\Models\OrderProduct::selectRaw('SUM(preparation_time) as total_preparation_time')
        ->join('products', 'order_products.product_id', '=', 'products.id')
        ->where('order_id', $order_id)->first();
}


function vendorOrderCountByRefund($vendor_id, $status)
{

    return Orders::where(['vendor_id' => $vendor_id, 'refund' => $status])->count();
}

function promotionRowSetup($Blogs,$request,$user_id){
    if(!empty($Blogs) && isset($Blogs[0])){
            $reponce       = [];
            $counter       = 0;
            if (isset($Blogs[0])) {
                foreach ($Blogs as $k => $blog) {
                    $data1 = null;
                    $blog_id                   = $blog->id;
                    $reponce[$counter]['blog'] = $blog;
                    //$blog->blog_type 1: vendor 2:product
                    if ($blog->blog_type == '1') {

                        $resturant = get_restaurant_near_me($request->lat, $request->lng, null, $user_id, null, null);

                        $resturant->join('app_promotion_blog_bookings', function ($query) {
                            $query->on('app_promotion_blog_bookings.vendor_id', '=', 'vendors.id');
                        });

                        $resturant->join('app_promotion_blog_settings',
                            function ($q) use ($blog_id) {
                                $q->on('app_promotion_blog_bookings.app_promotion_blog_setting_id', '=', 'app_promotion_blog_settings.id');
                                $q->where('app_promotion_blog_bookings.app_promotion_blog_id', $blog_id);
                                $q->orderBy('app_promotion_blog_settings.blog_position', 'asc');
                            });
                        $resturant->where('app_promotion_blog_bookings.app_promotion_blog_id', $blog->id);
                        $resturant->addSelect('app_promotion_blog_bookings.app_promotion_blog_id', 'app_promotion_blog_bookings.app_promotion_blog_setting_id',
                            'app_promotion_blog_bookings.vendor_id', 'from_date', 'to_date', 'from_time', 'to_time',
                            \DB::raw('CONCAT("' . asset('slot-vendor-image') . '/", app_promotion_blog_bookings.image ) as blog_promotion_image'),
                            'vendors.id as vendor_id')
                            ->where('app_promotion_blog_settings.is_active', 1)
                            ->where('app_promotion_blog_bookings.payment_status', 1)
                            ->orderBy('app_promotion_blog_settings.blog_position', 'asc');
                        $resturant = $resturant->get();


                        foreach ($resturant as $key => $value) {
                            if($value->banner_image!='') {
                                $banners = @json_decode(@$value->banner_image);
                                if (is_array($banners))
                                    $urlbanners = array_map(function ($banner) {
                                        return URL::to('vendor-banner/') . '/' . $banner;
                                    }, $banners);
                                else
                                    $urlbanners = [];
                                $resturant[$key]->banner_image = $urlbanners;
                            }
                            $resturant[$key]->cuisines       = \App\Models\Cuisines::whereIn('cuisines.id', explode(',', $value->deal_cuisines))->pluck('name');
                            $resturant[$key]->categories       = \App\Models\Catogory_master::whereIn('id', explode(',', $value->deal_categories))->pluck('name');
                        }

                        $data1     = $resturant;
                        $reponce[$counter]['blog']['vendors'] = $data1;
                        unset($data1);unset($resturant);
                    } else if ($blog->blog_type == '2') {
                        $resturant = get_restaurant_ids_near_me($request->lat, $request->lng, null, true, null, null);

                        $resturant->join('app_promotion_blog_bookings', function ($query) {
                            $query->on('app_promotion_blog_bookings.vendor_id', '=', 'vendors.id');
                        });
                        $resturant->join('app_promotion_blog_settings',
                            function ($q) use ($blog_id) {
                                $q->on('app_promotion_blog_bookings.app_promotion_blog_setting_id', '=', 'app_promotion_blog_settings.id');
                                $q->where('app_promotion_blog_bookings.app_promotion_blog_id', $blog_id);
                                $q->orderBy('app_promotion_blog_settings.blog_position', 'asc');
                            });

                        $resturant->where('app_promotion_blog_bookings.app_promotion_blog_id', $blog->id);

                        $resturant->addSelect('app_promotion_blog_bookings.app_promotion_blog_id',
                            'app_promotion_blog_bookings.app_promotion_blog_setting_id',
                            'app_promotion_blog_bookings.vendor_id', 'from_date', 'to_date', 'from_time', 'to_time',
                            'app_promotion_blog_bookings.product_id')
                            ->where('app_promotion_blog_settings.is_active', 1)
                            ->where('app_promotion_blog_bookings.payment_status', 1)
                            ->orderBy('app_promotion_blog_settings.blog_position', 'asc');
                        $resturants = $resturant->get();

                        foreach ($resturants as $k => $res){
                            $data1 = get_product_with_variant_and_addons(['products.id' => $res->product_id],
                                $request->user()->id, null, null, true);

                            $resturants[$k]['products'] = $data1;
                        }
                            
                         $reponce[$counter]['blog']['products'] = $resturants;
                        unset($data1);unset($resturant);
                    }
                   
                        
                    $counter++;
                }

            }
            return $reponce;
    }else{
        return [];
    }
}
function orderCancel($id)
    {
        // echo 'hello';die;

        $order = Orders::where('id',$id)->first();

        
        $payout = Paymentsetting::first();
        $order_amount = $order->net_amount;
        $vendor_cancellation = $payout->additions;
        $convenience_fee = $payout->convenience_fee;
        $admin_commision = $payout->admin_commision;
        $tax = 18 ;
       
        $gross_revenue = $order->gross_amount;
        // $vendor_commision = ($vendor_cancellation / 100) * $order_amount;
        $vendor_commision = 0;
        $admin_per = ($admin_commision / 100) * $vendor_commision;
        
        $tax_commision = ($tax / 100) * $admin_per;
        
        $convenience_commision = ($convenience_fee / 100) * ($gross_revenue + $vendor_commision);

        $deduction =  $admin_per + $tax_commision + $convenience_commision;        
        

        $net_receivables = ($gross_revenue + $vendor_commision) - $deduction;
        $ordercommision = array(
            'is_cancel' => 1,
            'vendor_id' => $order->vendor_id,
            'order_id' => $order->id,
            'vendor_commision' => $vendor_commision,
            'admin_commision' => $deduction,
            'net_amount' => $order_amount,           
            'gross_revenue' => $gross_revenue,
            'additions' => $vendor_commision,
            'deductions' => $deduction,
            'net_receivables' => $net_receivables,
            'convenience_tax' => $convenience_fee,
            'addition_tax' => $vendor_cancellation,
            'admin_tax' => $admin_commision,
            'tax' => $tax,
            'convenience_amount' => $convenience_commision,
            'tax_amount' => $tax_commision,
            'admin_amount' => $admin_per,
            'order_date' => date('Y-m-d H:i:s'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' =>date('Y-m-d H:i:s')
        );
       return  OrderCommision::create($ordercommision); 
    }

    function orderComplete($id)
    {
        $order = Orders::where('id',$id)->first();
        $payout = Paymentsetting::first();
        $order_amount = $order->net_amount;
        $convenience_fee = $payout->convenience_fee;
        $admin_commision = $payout->admin_commision;
        $tax = 18 ;
        $gross_revenue = $order_amount;
        $additions = 0;
        $convenience_commision = ($convenience_fee / 100) * $order_amount;
        $admin_per = ($admin_commision / 100) * $order_amount;
        $tax_commision = ($tax / 100) * $admin_per;
        $deduction =  $admin_per + $tax_commision + $convenience_commision; 
        $net_receivables = ($gross_revenue + $additions) - $deduction;

        $ordercommision = array(
            'is_approve' => 1,
            'vendor_id' => $order->vendor_id,
            'order_id' => $order->id,
            'vendor_commision' => $net_receivables,
            'admin_commision' => $deduction,
            'net_amount' => $order_amount,           
            'gross_revenue' => $gross_revenue,
            'additions' => $additions,
            'deductions' => $deduction,
            'net_receivables' => $net_receivables,
            'convenience_tax' => $convenience_fee,
            'addition_tax' => $additions,
            'admin_tax' => $admin_commision,
            'tax' => $tax,
            'convenience_amount' => $convenience_commision,
            'tax_amount' => $tax_commision,
            'admin_amount' => $admin_per,
            'order_date' => date('Y-m-d H:i:s'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' =>date('Y-m-d H:i:s')
        );
       return  OrderCommision::create($ordercommision);


    }
    function orderDetailForUser($order_id){
        $order =   \App\Models\Order::where('id','=',$order_id)->first();
        $order->order_date =  date("d M Y  h:i A",strtotime($order->created_at));
        $vendor = \App\Models\Vendors::where('id','=',$order->vendor_id)->select('name','image','lat','long')->first();
        $order->vendor_name = $vendor->name;
        $order->image = asset('vendors').'/'.$vendor->image;
        $order->vendor_lat = $vendor->lat;
        $order->vendor_long = $vendor->long;
        if($order->order_status == 'preparing'){
            if(\Carbon\Carbon::now()->lt($order->preparation_time_to)){
                $start  = \Carbon\Carbon::now();
                $end    = new Carbon($order->preparation_time_to);
                $order->preparingdiffrence = $start->diff($end)->format('%I');
            }else{
                $order->preparingdiffrence = '0';
            }
            
        }
        $products = \App\Models\OrderProduct::where('order_id', '=', $order_id)->join('products', 'order_products.product_id', 'products.id')->select('product_id', 'order_products.product_name', 'order_products.product_price', 'product_qty', 'type', 'order_products.id as order_product_id')->get();
           
            // foreach ($products as $k => $v) {
            //     $OrderProductAddon   = OrderProductAddon::where('order_product_id', '=', $v->order_product_id)->select('addon_name', 'addon_price', 'addon_qty')->get();
            //     $OrderProductVariant = OrderProductVariant::where('order_product_id', '=', $v->order_product_id)->select('variant_name', 'variant_price', 'variant_qty')->first();
            //     if (!empty($OrderProductVariant)) {
            //         $products[$k]->variant = $OrderProductVariant;
            //     }
            //     if (!empty($OrderProductAddon->toArray())) {
            //         $products[$k]->addons = $OrderProductAddon;
            //     }

            // }
        $order->products = $products;
            
        if($order->accepted_driver_id != null){
            $riderAssign = \App\Models\RiderAssignOrders::where(['rider_id' =>$order->accepted_driver_id])->whereNotIn('action', ['2', '5'])->orderBy('rider_assign_orders.id','desc')->limit(1);
            if($riderAssign->exists()){
                $riderAssign = $riderAssign->first();
                $order->rider_id = $riderAssign->rider_id;
                $order->order_row_id = $riderAssign->order_id;
                $order->distance = $riderAssign->distance;
                $order->earning = $riderAssign->earning;
                $order->cancel_reason = $riderAssign->cancel_reason;
                $order->action = $riderAssign->action;
                $order->otp = $riderAssign->otp;
                $driver = \App\Models\Deliver_boy::where('id','=',$riderAssign->rider_id)->select('*');
                $driver = $driver->addSelect(\DB::raw('CONCAT("' . asset('dliver-boy') . '/", image) AS image'));
                $driver = $driver->first();
                $order->driver_name = $driver->name;
                $order->driver_email = $driver->email;
                $order->mobile = $driver->mobile;
                $order->driver_image = $driver->image;
            }

        }
        return $order;
    }

    function blogPromotionPriceSetup ($request,$id){
        $AppPromotionBlogSetting= new \App\Models\AppPromotionBlogSetting;
        // 
        
        $AppPromotionBlogSetting->insert(['app_promotion_blog_id'=>$id,'blog_position'=>1,'blog_name'=>'First Position','blog_price' => $request['first_position_price_for_week'],'blog_promotion_date_frame'=>'7']);
        $AppPromotionBlogSetting->insert(['app_promotion_blog_id'=>$id,'blog_position'=>2,'blog_name'=>'Second Position','blog_price' => $request['second_position_price_for_week'],'blog_promotion_date_frame'=>'7']);
        $AppPromotionBlogSetting->insert(['app_promotion_blog_id'=>$id,'blog_position'=>3,'blog_name'=>'Third Position','blog_price' => $request['third_position_price_for_week'],'blog_promotion_date_frame'=>'7']);
        $AppPromotionBlogSetting->insert(['app_promotion_blog_id'=>$id,'blog_position'=>4,'blog_name'=>'Fourth Position','blog_price' => $request['fourth_position_price_for_week'],'blog_promotion_date_frame'=>'7']);
        $AppPromotionBlogSetting->insert(['app_promotion_blog_id'=>$id,'blog_position'=>5,'blog_name'=>'Fifth Position','blog_price' => $request['fifth_position_price_for_week'],'blog_promotion_date_frame'=>'7']);
        $AppPromotionBlogSetting->insert(['app_promotion_blog_id'=>$id,'blog_position'=>6,'blog_name'=>'Sixth Position','blog_price' => $request['sixth_position_price_for_week'],'blog_promotion_date_frame'=>'7']);
        $AppPromotionBlogSetting->insert(['app_promotion_blog_id'=>$id,'blog_position'=>7,'blog_name'=>'Seventh Position','blog_price' => $request['seventh_position_price_for_week'],'blog_promotion_date_frame'=>'7']);
        $AppPromotionBlogSetting->insert(['app_promotion_blog_id'=>$id,'blog_position'=>8,'blog_name'=>'Eighth Position','blog_price' => $request['eighth_position_price_for_week'],'blog_promotion_date_frame'=>'7']);
        $AppPromotionBlogSetting->insert(['app_promotion_blog_id'=>$id,'blog_position'=>9,'blog_name'=>'Ninth Position','blog_price' => $request['ninth_position_price_for_week'],'blog_promotion_date_frame'=>'7']);
        $AppPromotionBlogSetting->insert(['app_promotion_blog_id'=>$id,'blog_position'=>10,'blog_name'=>'Tenth Position','blog_price' => $request['tenth_position_price_for_week'],'blog_promotion_date_frame'=>'7']);
        // 
        $AppPromotionBlogSetting->insert(['app_promotion_blog_id'=>$id,'blog_position'=>1,'blog_name'=>'First Position','blog_price' => $request['first_position_price_for_two_week'],'blog_promotion_date_frame'=>'14']);
        $AppPromotionBlogSetting->insert(['app_promotion_blog_id'=>$id,'blog_position'=>2,'blog_name'=>'Second Position','blog_price' => $request['second_position_price_for_two_week'],'blog_promotion_date_frame'=>'14']);
        $AppPromotionBlogSetting->insert(['app_promotion_blog_id'=>$id,'blog_position'=>3,'blog_name'=>'Third Position','blog_price' => $request['third_position_price_for_two_week'],'blog_promotion_date_frame'=>'14']);
        $AppPromotionBlogSetting->insert(['app_promotion_blog_id'=>$id,'blog_position'=>4,'blog_name'=>'Fourth Position','blog_price' => $request['fourth_position_price_for_two_week'],'blog_promotion_date_frame'=>'14']);
        $AppPromotionBlogSetting->insert(['app_promotion_blog_id'=>$id,'blog_position'=>5,'blog_name'=>'Fifth Position','blog_price' => $request['fifth_position_price_for_two_week'],'blog_promotion_date_frame'=>'14']);
        $AppPromotionBlogSetting->insert(['app_promotion_blog_id'=>$id,'blog_position'=>6,'blog_name'=>'Sixth Position','blog_price' => $request['sixth_position_price_for_two_week'],'blog_promotion_date_frame'=>'14']);
        $AppPromotionBlogSetting->insert(['app_promotion_blog_id'=>$id,'blog_position'=>7,'blog_name'=>'Seventh Position','blog_price' => $request['seventh_position_price_for_two_week'],'blog_promotion_date_frame'=>'14']);
        $AppPromotionBlogSetting->insert(['app_promotion_blog_id'=>$id,'blog_position'=>8,'blog_name'=>'Eighth Position','blog_price' => $request['eighth_position_price_for_two_week'],'blog_promotion_date_frame'=>'14']);
        $AppPromotionBlogSetting->insert(['app_promotion_blog_id'=>$id,'blog_position'=>9,'blog_name'=>'Ninth Position','blog_price' => $request['ninth_position_price_for_two_week'],'blog_promotion_date_frame'=>'14']);
        $AppPromotionBlogSetting->insert(['app_promotion_blog_id'=>$id,'blog_position'=>10,'blog_name'=>'Tenth Position','blog_price' => $request['tenth_position_price_for_two_week'],'blog_promotion_date_frame'=>'14']);
        // 
        $AppPromotionBlogSetting->insert(['app_promotion_blog_id'=>$id,'blog_position'=>1,'blog_name'=>'First Position','blog_price' => $request['first_position_price_for_month'],'blog_promotion_date_frame'=>'30']);
        $AppPromotionBlogSetting->insert(['app_promotion_blog_id'=>$id,'blog_position'=>2,'blog_name'=>'Second Position','blog_price' => $request['second_position_price_for_month'],'blog_promotion_date_frame'=>'30']);
        $AppPromotionBlogSetting->insert(['app_promotion_blog_id'=>$id,'blog_position'=>3,'blog_name'=>'Third Position','blog_price' => $request['third_position_price_for_month'],'blog_promotion_date_frame'=>'30']);
        $AppPromotionBlogSetting->insert(['app_promotion_blog_id'=>$id,'blog_position'=>4,'blog_name'=>'Fourth Position','blog_price' => $request['fourth_position_price_for_month'],'blog_promotion_date_frame'=>'30']);
        $AppPromotionBlogSetting->insert(['app_promotion_blog_id'=>$id,'blog_position'=>5,'blog_name'=>'Fifth Position','blog_price' => $request['fifth_position_price_for_month'],'blog_promotion_date_frame'=>'30']);
        $AppPromotionBlogSetting->insert(['app_promotion_blog_id'=>$id,'blog_position'=>6,'blog_name'=>'Sixth Position','blog_price' => $request['sixth_position_price_for_month'],'blog_promotion_date_frame'=>'30']);
        $AppPromotionBlogSetting->insert(['app_promotion_blog_id'=>$id,'blog_position'=>7,'blog_name'=>'Seventh Position','blog_price' => $request['seventh_position_price_for_month'],'blog_promotion_date_frame'=>'30']);
        $AppPromotionBlogSetting->insert(['app_promotion_blog_id'=>$id,'blog_position'=>8,'blog_name'=>'Eighth Position','blog_price' => $request['eighth_position_price_for_month'],'blog_promotion_date_frame'=>'30']);
        $AppPromotionBlogSetting->insert(['app_promotion_blog_id'=>$id,'blog_position'=>9,'blog_name'=>'Ninth Position','blog_price' => $request['ninth_position_price_for_month'],'blog_promotion_date_frame'=>'30']);
        $AppPromotionBlogSetting->insert(['app_promotion_blog_id'=>$id,'blog_position'=>10,'blog_name'=>'Tenth Position','blog_price' => $request['tenth_position_price_for_month'],'blog_promotion_date_frame'=>'30']);
        
        
    
    }
    function blogPromotionPriceUpdate ($request,$id){
        //$AppPromotionBlogSetting= new \App\Models\AppPromotionBlogSetting;
        // 
        
        \App\Models\AppPromotionBlogSetting::where(['blog_promotion_date_frame'=>'7','app_promotion_blog_id'=>$id,'blog_position'=>1])->update(['blog_price' => $request['first_position_price_for_week']]);
        \App\Models\AppPromotionBlogSetting::where(['app_promotion_blog_id'=>$id,'blog_position'=>2,'blog_promotion_date_frame'=>'7'])->update(['blog_price' => $request['second_position_price_for_week']]);
        \App\Models\AppPromotionBlogSetting::where(['blog_promotion_date_frame'=>'7','app_promotion_blog_id'=>$id,'blog_position'=>3])->update(['blog_price' => $request['third_position_price_for_week']]);
        \App\Models\AppPromotionBlogSetting::where(['app_promotion_blog_id'=>$id,'blog_position'=>4,'blog_promotion_date_frame'=>'7'])->update(['blog_price' => $request['fourth_position_price_for_week']]);
        \App\Models\AppPromotionBlogSetting::where(['app_promotion_blog_id'=>$id,'blog_position'=>5,'blog_promotion_date_frame'=>'7'])->update(['blog_price' => $request['fifth_position_price_for_week']]);
        \App\Models\AppPromotionBlogSetting::where(['app_promotion_blog_id'=>$id,'blog_position'=>6,'blog_promotion_date_frame'=>'7'])->update(['blog_price' => $request['sixth_position_price_for_week']]);
        \App\Models\AppPromotionBlogSetting::where(['app_promotion_blog_id'=>$id,'blog_position'=>7,'blog_promotion_date_frame'=>'7'])->update(['blog_price' => $request['seventh_position_price_for_week']]);
        \App\Models\AppPromotionBlogSetting::where(['app_promotion_blog_id'=>$id,'blog_position'=>8,'blog_promotion_date_frame'=>'7'])->update(['blog_price' => $request['eighth_position_price_for_week']]);
        \App\Models\AppPromotionBlogSetting::where(['app_promotion_blog_id'=>$id,'blog_position'=>9,'blog_promotion_date_frame'=>'7'])->update(['blog_price' => $request['ninth_position_price_for_week']]);
        \App\Models\AppPromotionBlogSetting::where(['app_promotion_blog_id'=>$id,'blog_position'=>10,'blog_promotion_date_frame'=>'7'])->update(['blog_price' => $request['tenth_position_price_for_week']]);
        //
        \App\Models\AppPromotionBlogSetting::where(['blog_promotion_date_frame'=>'14','app_promotion_blog_id'=>$id,'blog_position'=>1])->update(['blog_price' => $request['first_position_price_for_two_week']]);
        \App\Models\AppPromotionBlogSetting::where(['app_promotion_blog_id'=>$id,'blog_position'=>2,'blog_promotion_date_frame'=>'14'])->update(['blog_price' => $request['second_position_price_for_two_week']]);
        \App\Models\AppPromotionBlogSetting::where(['blog_promotion_date_frame'=>'14','app_promotion_blog_id'=>$id,'blog_position'=>3])->update(['blog_price' => $request['third_position_price_for_two_week']]);
        \App\Models\AppPromotionBlogSetting::where(['app_promotion_blog_id'=>$id,'blog_position'=>4,'blog_promotion_date_frame'=>'14'])->update(['blog_price' => $request['fourth_position_price_for_two_week']]);
        \App\Models\AppPromotionBlogSetting::where(['app_promotion_blog_id'=>$id,'blog_position'=>5,'blog_promotion_date_frame'=>'14'])->update(['blog_price' => $request['fifth_position_price_for_two_week']]);
        \App\Models\AppPromotionBlogSetting::where(['app_promotion_blog_id'=>$id,'blog_position'=>6,'blog_promotion_date_frame'=>'14'])->update(['blog_price' => $request['sixth_position_price_for_two_week']]);
        \App\Models\AppPromotionBlogSetting::where(['app_promotion_blog_id'=>$id,'blog_position'=>7,'blog_promotion_date_frame'=>'14'])->update(['blog_price' => $request['seventh_position_price_for_two_week']]);
        \App\Models\AppPromotionBlogSetting::where(['app_promotion_blog_id'=>$id,'blog_position'=>8,'blog_promotion_date_frame'=>'14'])->update(['blog_price' => $request['eighth_position_price_for_two_week']]);
        \App\Models\AppPromotionBlogSetting::where(['app_promotion_blog_id'=>$id,'blog_position'=>9,'blog_promotion_date_frame'=>'14'])->update(['blog_price' => $request['ninth_position_price_for_two_week']]);
        \App\Models\AppPromotionBlogSetting::where(['app_promotion_blog_id'=>$id,'blog_position'=>10,'blog_promotion_date_frame'=>'14'])->update(['blog_price' => $request['tenth_position_price_for_two_week']]);
        //
        \App\Models\AppPromotionBlogSetting::where(['blog_promotion_date_frame'=>'30','app_promotion_blog_id'=>$id,'blog_position'=>1])->update(['blog_price' => $request['first_position_price_for_month']]);
        \App\Models\AppPromotionBlogSetting::where(['app_promotion_blog_id'=>$id,'blog_position'=>2,'blog_promotion_date_frame'=>'30'])->update(['blog_price' => $request['second_position_price_for_month']]);
        \App\Models\AppPromotionBlogSetting::where(['blog_promotion_date_frame'=>'30','app_promotion_blog_id'=>$id,'blog_position'=>3])->update(['blog_price' => $request['third_position_price_for_month']]);
        \App\Models\AppPromotionBlogSetting::where(['app_promotion_blog_id'=>$id,'blog_position'=>4,'blog_promotion_date_frame'=>'30'])->update(['blog_price' => $request['fourth_position_price_for_month']]);
        \App\Models\AppPromotionBlogSetting::where(['app_promotion_blog_id'=>$id,'blog_position'=>5,'blog_promotion_date_frame'=>'30'])->update(['blog_price' => $request['fifth_position_price_for_month']]);
        \App\Models\AppPromotionBlogSetting::where(['app_promotion_blog_id'=>$id,'blog_position'=>6,'blog_promotion_date_frame'=>'30'])->update(['blog_price' => $request['sixth_position_price_for_month']]);
        \App\Models\AppPromotionBlogSetting::where(['app_promotion_blog_id'=>$id,'blog_position'=>7,'blog_promotion_date_frame'=>'30'])->update(['blog_price' => $request['seventh_position_price_for_month']]);
        \App\Models\AppPromotionBlogSetting::where(['app_promotion_blog_id'=>$id,'blog_position'=>8,'blog_promotion_date_frame'=>'30'])->update(['blog_price' => $request['eighth_position_price_for_month']]);
        \App\Models\AppPromotionBlogSetting::where(['app_promotion_blog_id'=>$id,'blog_position'=>9,'blog_promotion_date_frame'=>'30'])->update(['blog_price' => $request['ninth_position_price_for_month']]);
        \App\Models\AppPromotionBlogSetting::where(['app_promotion_blog_id'=>$id,'blog_position'=>10,'blog_promotion_date_frame'=>'30'])->update(['blog_price' => $request['tenth_position_price_for_month']]);
        // // 
        
        
    
    }

    function createPdf($id)
    {
        
        $order = Orders::where('id',$id)->first();
        $vendor = Vendors::findOrFail($order->vendor_id);
        $users = User::findOrFail($order->user_id);
        $orderProduct = OrderProduct::findOrFail($id);
            $product_id = $orderProduct->product_id;
            $product = Product_master::where('id','=',$product_id)->select('id','product_name','product_image','primary_variant_name','product_price','type')->get();

        $invoiceName = rand(9999,99999).$id.'.pdf'; 
        $pdf = PDF::chunkLoadView('<html-separator/>', 'admin.pdf.pdf_document', compact('order','vendor','users','product'));
        $pdf->save(public_path('uploads/invoices/'. $invoiceName));
        $url = 'uploads/invoices/'. $invoiceName;

        $pdfUrl = Orders::where('id', '=', $id)->first();
        $pdfUrl->pdf_url = $url;
        $pdfUrl->save();
        return true;
    }


    function orderCancelByCustomer($order_id)
    {
       
        $order = Orders::where('id',$order_id)->first();
        
        $payout = Paymentsetting::first();
        $order_amount = $order->net_amount;
        $vendor_cancellation = $payout->additions;
        $convenience_fee = $payout->convenience_fee;
        $admin_commision = $payout->admin_commision;
        $tax = 18 ;
       
        $gross_revenue = $order->gross_amount;
        $vendor_commision = ($vendor_cancellation / 100) * $order_amount;
        $admin_per = ($admin_commision / 100) * $vendor_commision;
        
        $tax_commision = ($tax / 100) * $admin_per;
        
        $convenience_commision = ($convenience_fee / 100) * ($vendor_commision);

        $deduction =  $admin_per + $tax_commision + $convenience_commision;        
        

        $net_receivables = ($vendor_commision - $deduction);

        $ordercommision = array(
            'is_cancel' => 1,
            'vendor_id' => $order->vendor_id,
            'order_id' => $order->id,
            'vendor_commision' => $vendor_commision,
            'admin_commision' => $deduction,
            'net_amount' => $order_amount,
            'deductions' => $deduction,
            'convenience_tax' => $convenience_fee,
            'addition_tax' => $vendor_cancellation,
            'admin_tax' => $admin_commision,
            'tax' => $tax,
            'convenience_amount' => $convenience_commision,
            'tax_amount' => $tax_commision,
            'admin_amount' => $admin_per,
            'order_date' => date('Y-m-d H:i:s'),
            'created_at' => date('Y-m-d H:i:s'),

            'gross_revenue' => $vendor_commision,
            'additions' => $vendor_commision,
            'net_receivables' => $net_receivables,
            'updated_at' =>date('Y-m-d H:i:s')
        );
       

        $orderData = OrderCommision::where('order_id', $order_id)->first();

        if(isset($orderData)){
            $data = OrderCommision::where('order_id', $order_id)
            ->update($ordercommision);
          
        }else{
           
            OrderCommision::create($ordercommision);
        }
       
          
         return true;
    }