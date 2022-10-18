<?php

use App\Models\Orders;
use App\Models\Product_master;
use Carbon\Carbon;

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

function mysql_date($datetime)
{
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
    return Orders::where([ 'vendor_id' => $vendor_id, 'order_status' => $status ])->count();
}

function vendorTodayOrderCount($vendor_id)
{
    return Orders::where([ 'vendor_id' => $vendor_id ])->whereDate('created_at', Carbon::today())->count();
}

function vendorTotalOrderCount($vendor_id)
{
    return Orders::where([ 'vendor_id' => $vendor_id ])->count();
}

function in_between_equal_to($check_number, $from, $to)
{
    return ($from <= $check_number && $check_number <= $to);
}

function get_product_with_variant_and_addons($product_where = [], $user_id = '', $order_by_column = '', $order_by_order = '', $with_restaurant_name = false)
{
    DB::enableQueryLog();

    $product = Product_master::select(
        'variants.id as variant_id', 'variants.variant_name', 'variants.variant_price', 'preparation_time',
        'addons.id as addon_id', 'addons.addon', 'addons.price as addon_price',
        'products.id as product_id', 'products.product_name', 'product_price', 'customizable',
        DB::raw('CONCAT("' . asset('products') . '/", product_image) AS image'), 'cuisines.name as cuisinesName', 'dis as description',
        'products.id as product_id', DB::raw('if(user_product_like.user_id is not null, true, false)  as is_like'), 'product_rating', 'primary_variant_name')
        ->where([ 'products.status' => '1' ]);


    if (!empty($product_where))
        $product->where($product_where);

    if ($with_restaurant_name) {
        $product->join('vendors', 'products.userId', '=', 'vendors.id');
        $product->addSelect('vendors.name as restaurantName');
    }

    $product = $product->join('cuisines', 'products.cuisines', '=', 'cuisines.id');

    if ($user_id != '')
        $product = $product->leftJoin('user_product_like', function ($join) use ($user_id) {
            $join->on('products.id', '=', 'user_product_like.product_id');
            $join->where('user_product_like.user_id', '=', $user_id);
        });

    $product = $product->leftJoin('variants', 'variants.product_id', 'products.id')
        ->leftJoin('addons', function ($join) {
            $join->whereRaw(DB::raw("FIND_IN_SET(addons.id, products.addons)"));
        });
    $product = $product->orderBy('variants.id', 'ASC');
    if ($order_by_column != '' && $order_by_order != '')
        $product->orderBy($order_by_column, $order_by_order);
    $product = $product->get();


//    dd(\DB::getQueryLog ());
    $variant = [];
    if (count($product->toArray())) {
        foreach ($product as $i => $p) {
            if (!isset($variant[$p['product_id']])) {
                $variant[$p['product_id']] = [ 'product_id'           => $p['product_id'],
                                               'product_name'         => $p['product_name'],
                                               'product_price'        => $p['product_price'],
                                               'customizable'         => $p['customizable'],
                                               'image'                => $p['image'],
                                               'type'                 => $p['type'],
                                               'product_rating'       => $p['product_rating'],
                                               'categoryName'         => $p['categoryName'],
                                               'is_like'              => $p['is_like'],
                                               'primary_variant_name' => $p['primary_variant_name'],
                                               'preparation_time'     => $p['preparation_time'],
                ];
                if ($with_restaurant_name)
                    $variant[$p['product_id']] ['restaurantName'] = $p['restaurantName'];

            }
            if ($p->variant_id != '') {
                $variant[$p['product_id']]['options'][$p->variant_id] = [ 'id'            => $p->variant_id,
                                                                          'variant_name'  => $p->variant_name,
                                                                          'variant_price' => $p->variant_price ];
            }
            if ($p->addon_id != '')
                $variant[$p['product_id']]['addons'][$p->addon_id] = [ 'id'    => $p->addon_id,
                                                                       'addon' => $p->addon,
                                                                       'price' => $p->addon_price ];
        }
    }
    foreach ($variant as $i => $v) {
        if (isset($variant[$i]['options']))
            $variant[$i]['options'] = array_values($variant[$i]['options']);
        if (isset($variant[$i]['addons']))
            $variant[$i]['addons'] = array_values($variant[$i]['addons']);
    }
    $product = array_values($variant);

    return $product;
}

function get_restaurant_ids_near_me($lat, $lng, $where = [])
{

//    SELECT id, ( 3959 * acos(cos(radians(22.719568)) * cos(radians(lat)) * cos(radians(lng) - radians(75.857727)) + sin(radians(22.719568)) * sin(radians(lat ))) ) AS distance FROM markers HAVING distance < 50;

    $select  = "( 3959 * acos( cos( radians($lat) ) * cos( radians( vendors.lat ) ) * cos( radians( vendors.long ) - radians($lng) ) + sin( radians($lat) ) * sin( radians( vendors.lat ) ) ) ) ";
    $vendors = \App\Models\Vendors::where([ 'is_all_setting_done' => '1' ]);
    $vendors = $vendors->selectRaw("ROUND({$select},1) AS distance,id")
        ->having('distance', '<=', config('custom_app_setting.near_by_distance'));
    if (empty($where))
        $vendors->where($where);
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
