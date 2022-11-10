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

function get_product_with_variant_and_addons($product_where = [], $user_id = '', $order_by_column = '', $order_by_order = '', $with_restaurant_name = false, $is_chefleb_product = false, $where_vendor_in = null, $offset = null, $limit = null, $return_total_count = false, $product_ids = null)
{
    DB::enableQueryLog();
    //for pagination

    $product = Product_master::where(['products.status' => '1'])
        ->where(['products.product_approve' => '1']);


    if (!empty($product_where))
        $product->where($product_where);

    //    if (!empty($where_vendor_in))
    if ($where_vendor_in != null && is_array($where_vendor_in))
        $product->whereIn('vendors.id', $where_vendor_in);
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
        $product->addSelect('vendors.name as restaurantName', 'vendors.image as vendor_image', 'banner_image');
    }


    $product = $product->join('cuisines', 'products.cuisines', '=', 'cuisines.id');

    if ($user_id != '') {
        $product->addSelect('user_id', DB::raw('if(user_product_like.user_id is not null, true, false)  as is_like'));
        $product = $product->leftJoin('user_product_like', function ($join) use ($user_id) {
            $join->on('products.id', '=', 'user_product_like.product_id');
            $join->where('user_product_like.user_id', '=', $user_id);
        });
    }

    $product = $product->leftJoin('variants', 'variants.product_id', 'products.id')
        ->leftJoin('addons', function ($join) {
            $join->whereRaw(DB::raw("FIND_IN_SET(addons.id, products.addons)"));
        });
    $product = $product->orderBy('variants.id', 'ASC');
    if ($order_by_column != '' && $order_by_order != '')
        $product->orderBy($order_by_column, $order_by_order);
//    dd($product->get()->toArray());
    $product = $product->addSelect(DB::raw('products.userId as vendor_id'),
        'variants.id as variant_id', 'variants.variant_name', 'variants.variant_price', 'preparation_time', 'chili_level', 'type',
        'addons.id as addon_id', 'addons.addon', 'addons.price as addon_price',
        'products.id as product_id','products.dis as description', 'products.product_name', 'product_price','dis', 'customizable',
        DB::raw('CONCAT("' . asset('products') . '/", product_image) AS image'), 'cuisines.name as cuisinesName', 'dis as description',
        'products.id as product_id', 'product_rating','tax', 'primary_variant_name')
        ->get();
//dd($product->toArray());
//    dd(\DB::getQueryLog());
    $variant = [];
    if (count($product->toArray())) {
        foreach ($product as $i => $p) {
            if (!isset($variant[$p['product_id']])) {
                $variant[$p['product_id']] = ['product_id'           => $p['product_id'],
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
                                              'vendor_id'            => $p['vendor_id'],
                                              'chili_level'          => $p['chili_level']
                ];
                if ($with_restaurant_name) {
                    $variant[$p['product_id']] ['restaurantName'] = $p['restaurantName'];
                    $variant[$p['product_id']] ['vendor_image']   = asset('vendors') . $p['vendor_image'];

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
                $variant[$p['product_id']]['options'][$p->variant_id] = ['id'            => $p->variant_id,
                                                                         'variant_name'  => $p->variant_name,
                                                                         'variant_price' => $p->variant_price];
            }
            if ($p->addon_id != '')
                $variant[$p['product_id']]['addons'][$p->addon_id] = ['id'    => $p->addon_id,
                                                                      'addon' => $p->addon,
                                                                      'price' => $p->addon_price];
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

    $select  = "( 3959 * acos( cos( radians($lat) ) * cos( radians( vendors.lat ) ) * cos( radians( vendors.long ) - radians($lng) ) + sin( radians($lat) ) * sin( radians( vendors.lat ) ) ) ) ";
    $vendors = \App\Models\Vendors::where(['vendors.status' => '1', 'is_all_setting_done' => '1']);
    $vendors = $vendors->selectRaw("ROUND({$select},1) AS distance")->addSelect("vendors.id");
    $vendors->having('distance', '<=', config('custom_app_setting.near_by_distance'));

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

function get_delivery_boy_near_me($lat, $lng)
{

    return [1];
}

function get_restaurant_near_me($lat, $lng, $where = [], $current_user_id, $offset = null, $limit = null)
{
    date_default_timezone_set('Asia/Kolkata');
    $vendors = get_restaurant_ids_near_me($lat, $lng, $where, true);

    $vendors->leftJoin('vendor_order_time', function ($join) {
        $join->on('vendor_order_time.vendor_id', '=', 'vendors.id')
            ->where('vendor_order_time.day_no', '=', Carbon::now()->dayOfWeek)
            //--------------commented, we are sending is open and is_closed
//            ->where('start_time', '<=', mysql_time())
//            ->where('end_time', '>', mysql_time())
            ->where('available', '=', 1);
    });

    if ($where != null && !empty($where)) {
        $vendors->where($where);
    }

    if ($current_user_id != null) {
        $vendors->leftJoin('user_vendor_like', function ($join) use ($current_user_id) {
            $join->on('vendors.id', '=', 'user_vendor_like.vendor_id');
            $join->where('user_vendor_like.user_id', '=', $current_user_id);
        })->addSelect(\DB::raw('if(user_vendor_like.user_id is not null, true, false)  as is_like'));
    }
    $vendors->addSelect('vendor_type', 'is_all_setting_done', 'start_time', 'end_time', 'vendor_order_time.day_no', 'vendors.name', "vendor_food_type",
        'vendor_ratings', 'vendors.lat', 'vendors.long', 'deal_categories','fssai_lic_no','tax',
        \DB::raw('CONCAT("' . asset('vendors') . '/", vendors.image) AS image'),
        DB::raw('if(available,false,true)  as isClosed')
    );

    if (!empty($limit) && !empty($offset))
        $vendors->offset($offset)->limit($limit);

//    dd($vendors->get()->toArray());
    return $vendors;

}

function next_available_day($vendor_id, $return_obj = false)
{
    $today = \Carbon\Carbon::now()->dayOfWeek;
//    $today=6;
    if ($today == 6)
        $next_available_day = \App\Models\VendorOrderTime::where('day_no', '>=', 0)->where('available', 1)->orderBy('day_no')->first();
    else
        $next_available_day = \App\Models\VendorOrderTime::where('day_no', '>=', $today)->where('available', 1)->orderBy('day_no')->first();

    if (!isset($next_available_day->id))
        $next_available_day = \App\Models\VendorOrderTime::where('day_no', '>=', 0)->where('available', 1)->orderBy('day_no')->first();
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
    ->where('vendor_food_type','=','3')
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
