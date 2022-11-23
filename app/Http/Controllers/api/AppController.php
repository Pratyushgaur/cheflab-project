<?php

namespace App\Http\Controllers\api;

use App\Events\OrderCreateEvent;
use App\Http\Controllers\Controller;
use App\Models\Addons;
use App\Models\AdminMasters;
use App\Models\Catogory_master;
use App\Models\Chef_video;
use App\Models\ContactUs;
use App\Models\Coupon;
use App\Models\Cuisines;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\OrderProductAddon;
use App\Models\OrderProductVariant;
use App\Models\Product_master;
use App\Models\RiderAssignOrders;
use App\Models\User;
use App\Models\UserProductLike;
use App\Models\UserVendorLike;
use App\Models\Variant;
use App\Models\VendorMenus;
use App\Models\VendorOrderTime;
use App\Models\Vendors;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDOException;
use Throwable;
use URL;
use Validator;


class AppController extends Controller
{
    /*
        public function getProductDetail(Request $request)
        {
            try {
                $validateUser = Validator::make(
                    $request->all(),
                    [
                        'product_id' => 'required|numeric'
                    ]
                );
                if ($validateUser->fails()) {
                    $error = $validateUser->errors();
                    return response()->json([
                        'status' => false,
                        'error' => $validateUser->errors()->all()

                    ], 401);
                }
                $product = Product_master::where(['products.id' => $request->product_id]);
                $product = $product->join('cuisines', 'products.cuisines', '=', 'cuisines.id');
                $product = $product->leftJoin('user_product_like',function($join){
                    $join->on('products.id', '=', 'user_product_like.product_id');
                    $join->where('user_product_like.user_id', '=',request()->user()->id );
                });
                $product = $product->select('products.product_name', 'product_price', 'customizable', \DB::raw('CONCAT("' . asset('products') . '/", product_image) AS image'), 'cuisines.name as cuisinesName', 'dis as description','products.id as product_id',\DB::raw('if(user_product_like.user_id is not null, true, false)  as is_like'),'product_rating')->first();


                return response()->json([
                    'status' => true,
                    'message' => 'Data Get Successfully',
                    'response' => $product

                ], 200);
            } catch (Throwable $th) {
                return response()->json([
                    'status' => false,
                    'error' => $th->getMessage()
                ], 500);
            }
        }
    */
    public function getProductDetail(Request $request)
    {
        try {
            $validateUser = Validator::make(
                $request->all(),
                [
                    'product_id' => 'required|numeric'
                ]
            );
            if ($validateUser->fails()) {
                $error = $validateUser->errors();
                return response()->json([
                    'status' => false,
                    'error'  => $validateUser->errors()->all()

                ], 401);
            }

            $products = get_product_with_variant_and_addons(['products.id' => $request->product_id], request()->user()->id);

            return response()->json([
                'status'   => true,
                'message'  => 'Data Get Successfully',
                'response' => $products

            ], 200);
        } catch (Throwable $th) {
            return response()->json([
                'status' => false,
                'error'  => $th->getMessage()
            ], 500);
        }
    }

    //
    function calculateDistanceBetweenTwoAddresses($lat1, $lng1, $lat2, $lng2)
    {
        $lat1 = deg2rad($lat1);
        $lng1 = deg2rad($lng1);

        $lat2 = deg2rad($lat2);
        $lng2 = deg2rad($lng2);

        $delta_lat = $lat2 - $lat1;
        $delta_lng = $lng2 - $lng1;

        $hav_lat = (sin($delta_lat / 2)) ** 2;
        $hav_lng = (sin($delta_lng / 2)) ** 2;

        $distance = 2 * asin(sqrt($hav_lat + cos($lat1) * cos($lat2) * $hav_lng));

        $distance = 3959 * $distance;
        // If you want calculate the distance in miles instead of kilometers, replace 6371 with 3959.

        return $distance;
    }

    //restaurant page
    public function restaurantHomePage(Request $request)
    {
        try {
            $validateUser = Validator::make(
                $request->all(),
                [
                    'lat'            => 'required|numeric',
                    'lng'            => 'required|numeric',
                    'vendor_offset'  => 'required|numeric',
                    'vendor_limit'   => 'required|numeric',
                    'product_offset' => 'required|numeric',
                    'product_limit'  => 'required|numeric',
                ]
            );
            if ($validateUser->fails()) {
                $error = $validateUser->errors();
                return response()->json([
                    'status' => false,
                    'error'  => $validateUser->errors()->all()

                ], 401);
            }

            $userid  = request()->user()->id;
            $where   = ['vendor_type' => 'restaurant'];
            $vendors = get_restaurant_near_me($request->lat, $request->lng, $where, request()->user()->id, null, null);
            $vendors = $vendors->addSelect('deal_cuisines', 'banner_image')->orderBy('vendors.id', 'desc')->offset($request->vendor_offset)->limit($request->vendor_limit)->get();

            $vendor_ids = get_restaurant_ids_near_me($request->lat, $request->lng, $where, false);//not need to pass offset; limit set on products
            //get productd's shoud display in pagination
            $products_ids = get_product_with_variant_and_addons(['product_for' => '3'], request()->user()->id, 'products.id', 'desc', true, false, $vendor_ids, $request->product_offset, $request->product_limit);
            // product details
            $products = get_product_with_variant_and_addons(['product_for' => '3'], request()->user()->id, 'products.id', 'desc', true, false, $vendor_ids, null, null, false, $products_ids);
            // total products


            foreach ($vendors as $key => $value) {
                $banners = json_decode($value->banner_image);
                if (is_array($banners))
                    $urlbanners = array_map(function ($banner) {
                        return URL::to('vendor-banner/') . '/' . $banner;
                    }, $banners);
                else
                    $urlbanners = [];
                $vendors[$key]->banner_image   = $urlbanners;
                $vendors[$key]->cuisines       = Cuisines::whereIn('cuisines.id', explode(',', $value->deal_cuisines))->pluck('name');
                $category                      = Catogory_master::whereIn('id', explode(',', $value->deal_categories))->pluck('name');
                $vendors[$key]->categories     = $category;
                $vendors[$key]->next_available = next_available_day($value->id);
            }

            return response()->json([
                'status'   => true,
                'message'  => 'Data Get Successfully',
                'response' => [
                    'vendors'  => $vendors,
                    'products' => $products]

            ], 200);
        } catch (Throwable $th) {
            return response()->json([
                'status'     => false,
                'error'      => $th->getMessage(),
                'errortrace' => $th->getTrace()
            ], 500);
        }
    }

    public function getRestaurantByCategory(Request $request)
    {
        try {
            $validateUser = Validator::make(
                $request->all(),
                [
                    'category_id'   => 'required|numeric',
                    'lat'           => 'required|numeric',
                    'lng'           => 'required|numeric',
                    'vendor_offset' => 'required|numeric',
                    'vendor_limit'  => 'required|numeric'
                ]
            );
            if ($validateUser->fails()) {
                $error = $validateUser->errors();
                return response()->json([
                    'status' => false,
                    'error'  => $validateUser->errors()->all()

                ], 401);
            }
//DB::enableQueryLog();
            $user_id      = request()->user()->id;
            $vendor_count = get_restaurant_near_me($request->lat, $request->lng, ['vendor_type' => 'restaurant'], null, null, null);
            $vendor_count = $vendor_count->whereRaw('FIND_IN_SET(' . $request->category_id . ',deal_categories)');
            if (!empty($request->filter)) {
                if (in_array("1", $request->filter)) {

                    $vendor_count->orderBy('vendor_ratings', 'DESC');
                }
                $vendor_count->where(function ($q) use ($request) {
                    if (in_array("2", $request->filter)) {
                        $q->orWhere(['vendor_food_type' => '1']);
                    }
                    if (in_array("3", $request->filter)) {
                        $q->orWhere(['vendor_food_type' => '3']);
                    }
                });
            }
            $vendor_count = $vendor_count->count();
//dd(DB::getQueryLog());

            $vendor_obj = get_restaurant_near_me($request->lat, $request->lng, ['vendor_type' => 'restaurant'], $user_id, null, null);
            if (!empty($request->filter)) {
                if (in_array("1", $request->filter)) {

                    $vendor_obj->orderBy('vendor_ratings', 'DESC');
                }

                $vendor_obj->where(function ($q) use ($request) {
                    if (in_array("2", $request->filter)) {
                        $q->orWhere(['vendor_food_type' => '1']);
                    }
                    if (in_array("3", $request->filter)) {
                        $q->orWhere(['vendor_food_type' => '3']);
                    }
                });
            }
            $vendor_obj->addSelect('deal_cuisines')->addSelect('banner_image', 'vendor_food_type', 'fssai_lic_no', 'table_service')
                ->whereRaw('FIND_IN_SET("' . $request->category_id . '",deal_categories)');

            $data = $vendor_obj->offset($request->vendor_offset)->limit($request->vendor_limit)->get();

            //            date_default_timezone_set('Asia/Kolkata');
            $baseurl = URL::to('vendor-banner/') . '/';
            foreach ($data as $key => $value) {
                $banners = json_decode($value->banner_image);
                if (is_array($banners))
                    $urlbanners = array_map(function ($banner) {
                        return URL::to('vendor-banner/') . '/' . $banner;
                    }, $banners);
                else
                    $urlbanners = [];

                $data[$key]->cuisines       = Cuisines::whereIn('cuisines.id', explode(',', $value->deal_cuisines))->pluck('name');
                $category                   = Catogory_master::whereIn('id', explode(',', $value->deal_categories))->pluck('name');
                $data[$key]->categories     = $category;
                $data[$key]->imageUrl       = $baseurl;
                $data[$key]->banner_image   = $urlbanners;
                $data[$key]->next_available = next_available_day($value->id);
            }
            return response()->json([
                'status'   => true,
                'message'  => 'Data Get Successfully',
                'response' => ['vendor_total_records' => $vendor_count,
                               'vendors'              => $data]

            ], 200);
        } catch (Throwable $th) {
            return response()->json([
                'status' => false,
                'error'  => $th->getMessage()
            ], 500);
        }
    }

    public function getRestaurantByCuisines(Request $request)
    {
        try {
            $validateUser = Validator::make(
                $request->all(),
                [
                    'cuisines_id'   => 'required|numeric',
                    'lat'           => 'required|numeric',
                    'lng'           => 'required|numeric',
                    'vendor_offset' => 'required|numeric',
                    'vendor_limit'  => 'required|numeric',

                ]
            );
            if ($validateUser->fails()) {
                $error = $validateUser->errors();
                return response()->json(['status' => false, 'error' => $validateUser->errors()->all()], 401);
            }
            \DB::enableQueryLog();
            $vendor_obj = get_restaurant_near_me($request->lat, $request->lng, ['vendor_type' => 'restaurant'], request()->user()->id);
            $vendor_obj->addSelect('deal_cuisines', 'banner_image', 'fssai_lic_no', 'table_service')
                ->whereRaw('FIND_IN_SET("' . $request->cuisines_id . '",deal_cuisines)');
            if (!empty($request->filter)) {
                if (in_array("1", $request->filter)) {

                    $vendor_obj->orderBy('vendor_ratings', 'DESC');
                }
                $vendor_obj->where(function ($q) use ($request) {
                    if (in_array("2", $request->filter)) {
                        $q->orWhere(['vendor_food_type' => '1']);

                    }
                    if (in_array("3", $request->filter)) {
                        $q->orWhere(['vendor_food_type' => '3']);
                    }
                });
            }
            $vendor_obj1  = $vendor_obj;
            $vendor_count = $vendor_obj1->count();
            $data         = $vendor_obj->offset($request->vendor_offset)->limit($request->vendor_limit)->get();

            dd(DB::getQueryLog());
            $baseurl = URL::to('vendor-banner/') . '/';
            foreach ($data as $key => $value) {
                $banners = json_decode($value->banner_image);
                if (is_array($banners))
                    $urlbanners = array_map(function ($banner) {
                        return URL::to('vendor-banner/') . '/' . $banner;
                    }, $banners);
                else
                    $urlbanners = '';
                $data[$key]->cuisines       = Cuisines::whereIn('cuisines.id', explode(',', $value->deal_cuisines))->pluck('name');
                $category                   = Catogory_master::whereIn('id', explode(',', $value->deal_categories))->pluck('name');
                $data[$key]->categories     = $category;
                $data[$key]->imageUrl       = $baseurl;
                $data[$key]->banner_image   = $urlbanners;
                $data[$key]->next_available = next_available_day($value->id);

            }
            return response()->json([
                'status'   => true,
                'message'  => 'Data Get Successfully',
                'response' => [
                    'vendor_total_records' => $vendor_count,
                    'vendors'              => $data]


            ], 200);
        } catch (Throwable $th) {
            return response()->json([
                'status' => false,
                'error'  => $th->getMessage()
            ], 500);
        }
    }

    public function getRestaurantDetailPage(Request $request)
    {
        try {
            $validateUser = Validator::make(
                $request->all(),
                [
                    'vendor_id' => 'required|numeric'
                ]
            );
            if ($validateUser->fails()) {
                $error = $validateUser->errors();
                return response()->json([
                    'status' => false,
                    'error'  => $validateUser->errors()->all()

                ], 401);
            }
            $category = VendorMenus::query()
                ->select('menuName', 'vendor_menus.id', \DB::raw('count(*) as count'))
                ->join('products as c', 'vendor_menus.id', 'c.menu_id')
                ->where('vendor_menus.vendor_id', '=', $request->vendor_id)
                ->where('product_approve', 1)
                ->where('status', 1)
                ->groupBy('menuName')
                ->get();
            // $category = VendorMenus::where(['vendor_id' => $request->vendor_id])->select('menuName', 'id')->groupBy('menuName')->get();
            $date    = today()->format('Y-m-d');
            $coupon  = Coupon::where('vendor_id', '=', $request->vendor_id)->where('status', '=', 1)->where('from', '<=', $date)->where('to', '>=', $date)->select('*')->get();
            $catData = [];

            foreach ($category as $key => $value) {
                /*              $product = Product_master::where(['products.status' => '1', 'product_for' => '3']);
                              $product = $product->join('categories', 'products.category', '=', 'categories.id');
                              $product = $product->leftJoin('user_product_like', function ($join) {
                                  $join->on('products.id', '=', 'user_product_like.product_id');
                                  $join->where('user_product_like.user_id', '=', request()->user()->id);
                              });
                              $product = $product->where('menu_id', '=', $value->id);
                              $product = $product->select(
              //                    'addons.*','addons.price as addon_price','addons.id as addon_id','addons.addon as addon_name',
                                  'variants.id as variant_id', 'variants.variant_price', 'variants.variant_name',
                                  'products.product_name', 'product_price', 'customizable', 'products.addons',
                                  \DB::raw('CONCAT("' . asset('products') . '/", product_image) AS image'), 'type', 'products.id as product_id', 'product_rating', 'categories.name as categoryName', \DB::raw('if(user_product_like.user_id is not null, true, false)  as is_like'));
                              $product = $product->leftJoin('variants', 'variants.product_id', 'products.id');
              //                $product = $product->leftJoin("addons", \DB::raw("FIND_IN_SET(addons, addons.id)"), ">", \DB::raw("'0'"));
              //                $product = $product->leftJoin("addons",function($q){
              //                    $q->whereRaw(\DB::raw("FIND_IN_SET(addons, addons.id)"));
              //                });
                              $product = $product->get();
              //                dd(\DB::getQueryLog ());
              //                dd($product->toArray());

                              \DB::enableQueryLog();

                              //+
                              if (count($product->toArray())) {
              //                    $value->products = $product;
                                  foreach ($product as $i => $p) {

                                      if (!isset($variant[$p['product_id']])) {
              //                            dd($p['addons']);
                                          $addons = Addons::whereRaw(\DB::raw("FIND_IN_SET(addons.id, '" . $p['addons'] . "')"))->get()->toArray();
              //                            print_r($addons);
              //                            dd(\DB::getQueryLog ());
                                          $variant[$p['product_id']] = ['product_id' => $p['product_id'],
                                              'product_name' => $p['product_name'],
                                              'product_price' => $p['product_price'],
                                              'customizable' => $p['customizable'],
                                              'image' => $p['image'],
                                              'type' => $p['type'],
                                              'product_rating' => $p['product_rating'],
                                              'categoryName' => $p['categoryName'],
                                              'is_like' => $p['is_like']
                                          ];
                                          if (count($addons))
                                              $variant[$p['product_id']]['addons'] = $addons;
                                      }
                                      if ($p->variant_id != '') {
                                          $variant[$p['product_id']]['options'][$p->variant_id] = ['id' => $p->variant_id,
                                              'variant_name' => $p->variant_name,
                                              'variant_price' => $p->variant_price];
                                      }
                                      if ($p->addon_id != '')
                                          $variant[$p['product_id']]['addons'][$p->addon_id] = ['id' => $p->addon_id,
                                              'addon' => $p->addon,
                                              'price' => $p->addon_price];
                                  }
                                  foreach ($variant as $i => $v) {
                                      if (isset($variant[$i]['options']))
                                          $variant[$i]['options'] = array_values($variant[$i]['options']);
                                      if (isset($variant[$i]['addons']))
                                          $variant[$i]['addons'] = array_values($variant[$i]['addons']);
                                  }
                                  $variant = array_values($variant);
              */
                $variant = get_product_with_variant_and_addons(['product_for' => '3', 'menu_id' => $value->id], request()->user()->id, '', '', false);
                if (!empty($variant)) {
                    $catData[] = ['menuName' => $value->menuName,
                                  'menu_id'  => $value->id,
                                  'products' => $variant];
                }


            }
            return response()->json([
                'status'   => true,
                'message'  => 'Data Get Successfully',
                'response' => array('products' => $catData, 'coupons' => $coupon)

            ], 200);
        } catch (Throwable $th) {
            return response()->json([
                'status' => false,
                'error'  => $th->getMessage()
            ], 500);
        }
    }

    public function getRestaurantDetailByFoodtype(Request $request)
    {
        try {
            $validateUser = Validator::make(
                $request->all(),
                [
                    'vendor_id' => 'required|numeric',
                    'food_type' => 'required|in:veg,non_veg,eggs'
                ]
            );
            if ($validateUser->fails()) {
                $error = $validateUser->errors();
                return response()->json([
                    'status' => false,
                    'error'  => $validateUser->errors()->all()

                ], 401);
            }


            $category = VendorMenus::where(['vendor_id' => $request->vendor_id])->select('menuName', 'id')->get();
            $data     = [];
            $dk       = 0;
            foreach ($category as $key => $value) {
                $product_where = ['products.status' => '1', 'product_for' => '3', 'type' => $request->food_type, 'menu_id' => $value->id];
                $product       = get_product_with_variant_and_addons($product_where, request()->user()->id, null, null, $with_restaurant_name = true,
                    $is_chefleb_product = false, $where_vendor_in = null, null, null, $return_total_count = false);

                $data[$key] = array('menuName' => $value->menuName, 'id' => $value->id, 'products' => $product);


//                $product = Product_master::where(['products.status' => '1', 'product_for' => '3']);
//                $product = $product->join('categories', 'products.category', '=', 'categories.id');
//                $product = $product->leftJoin('user_product_like', function ($join) {
//                    $join->on('products.id', '=', 'user_product_like.product_id');
//                    $join->where('user_product_like.user_id', '=', request()->user()->id);
//                });
//                $product = $product->where('menu_id', '=', $value->id);
//                $product = $product->select('products.product_name', 'product_price', 'customizable', \DB::raw('CONCAT("' . asset('products') . '/", product_image) AS image'), 'type', 'products.id as product_id', 'product_rating', 'categories.name as categoryName', \DB::raw('if(user_product_like.user_id is not null, true, false)  as is_like'));
//                $product = $product->where('type', '=', $request->food_type);
//                if ($product->exists()) {
//                    $product   = $product->get();
//                    $data[$dk] = array('menuName' => $value->menuName, 'id' => $value->id, 'products' => $product);
//
//                    $dk++;
//                }


            }

            return response()->json([
                'status'   => true,
                'message'  => 'Data Get Successfully',
                'response' => $data

            ], 200);
        } catch (Throwable $th) {
            return response()->json(['status' => false,
                                     'error'  => $th->getMessage()], 500);
        }
    }

    public function getRestaurantBrowsemenu(Request $request)
    {
        try {
            $validateUser = Validator::make(
                $request->all(),
                [
                    'vendor_id' => 'required|numeric'
                ]
            );
            if ($validateUser->fails()) {
                $error = $validateUser->errors();
                return response()->json([
                    'status' => false,
                    'error'  => $validateUser->errors()->all()

                ], 401);
            }
            //
            $category = VendorMenus::query()
                ->select('menuName', \DB::raw('count(*) as count'), 'vendor_menus.id as menu_id')
                ->join('products as c', 'vendor_menus.id', 'c.menu_id')
                ->where('vendor_menus.vendor_id', '=', $request->vendor_id)
                ->where('product_approve', 1)
                ->where('status', 1)
                ->groupBy('menuName')
                ->get();
            //
            return response()->json([
                'status'   => true,
                'message'  => 'Data Get Successfully',
                'response' => $category

            ], 200);
        } catch (Throwable $th) {
            return response()->json([
                'status' => false,
                'error'  => $th->getMessage()
            ], 500);
        }
    }

    public function getRestaurantCustmizeProductData(Request $request)
    {
        try {
            $validateUser = Validator::make(
                $request->all(),
                [
                    'product_id' => 'required|numeric'
                ]
            );
            if ($validateUser->fails()) {
                $error = $validateUser->errors();
                return response()->json([
                    'status' => false,
                    'error'  => $validateUser->errors()->all()

                ], 401);
            }
            //
            $product = Product_master::where('id', '=', $request->product_id)->select('addons', 'customizable')->first();

            if (@$product->customizable == 'true') {
                $options = unserialize($product->variants);
                if ($product->addons == null) {
                    $data = ['addons' => []];
                } else {
                    $addon = Addons::whereIn('id', explode(',', $product->addons))->select('id', 'addon', 'price')->get()->toArray();
                    $data  = ['addons' => $addon];
                }

                $v = Variant::select('variant_name', 'variant_price', 'id')->where('product_id', $request->product_id)->get();
                // dd($v->toArray());
                if (isset($v))
                    $data['options'] = $v->toArray();

                // dd($product);
                return response()->json([
                    'status'   => true,
                    'message'  => 'Data Get Successfully',
                    'response' => $data

                ], 200);
            } else {
                return response()->json([
                    'status' => false,
                    'error'  => 'Custmization not available'

                ], 401);
            }
        } catch (Throwable $th) {
            return response()->json([
                'status' => false,
                'error'  => $th->getMessage()
            ], 500);
        }
    }

    public function getRestaurantSearchData(Request $request)
    {
        try {
            $validateUser = Validator::make(
                $request->all(),
                [
                    'keyword'    => 'required',
                    'search_for' => 'required',
                    'offset'     => 'required|numeric',
                    'lat'        => 'required|numeric',
                    'lng'        => 'required|numeric',
                ]
            );
            if ($validateUser->fails()) {
                $error = $validateUser->errors();
                return response()->json([
                    'status' => false,
                    'error'  => $validateUser->errors()->all()

                ], 401);
            }
            //

            if ($request->search_for == 'restaurant') {
                $data = get_restaurant_near_me($request->lat, $request->lng, ['vendor_type' => 'restaurant'], $request->user()->id)
                    ->addSelect('review_count', 'deal_cuisines', 'fssai_lic_no', 'banner_image', 'vendor_food_type', 'table_service')
                    ->where('name', 'like', '%' . $request->keyword . '%')->skip($request->offset)->take(10)->get();
//                $data = Vendors::where(['status' => '1', 'vendor_type' => 'restaurant', 'is_all_setting_done' => '1'])
//                    ->select('name', \DB::raw('CONCAT("' . asset('vendors') . '/", image) AS image'), 'vendor_ratings', 'review_count')
//                    ->where('name', 'like', '%' . $request->keyword . '%')->skip($request->offset)->take(10)->get();
                // foreach ($data as $key => $value) {
                //     $data[$key]->cuisines       = Cuisines::whereIn('cuisines.id', explode(',', $value->deal_cuisines))->pluck('name');
                //     $data[$key]->categories     = Catogory_master::whereIn('id', explode(',', $value->deal_categories))->pluck('name');
                //     $data[$key]->next_available = next_available_day($value->id);
                // }

                $baseurl = URL::to('vendor-banner/') . '/';
                foreach ($data as $key => $value) {
                    $banners = json_decode($value->banner_image);
                    if (is_array($banners))
                        $urlbanners = array_map(function ($banner) {
                            return URL::to('vendor-banner/') . '/' . $banner;
                        }, $banners);
                    else
                        $urlbanners = [];

                    $data[$key]->cuisines       = Cuisines::whereIn('cuisines.id', explode(',', $value->deal_cuisines))->pluck('name');
                    $category                   = Catogory_master::whereIn('id', explode(',', $value->deal_categories))->pluck('name');
                    $data[$key]->categories     = $category;
                    $data[$key]->imageUrl       = $baseurl;
                    $data[$key]->banner_image   = $urlbanners;
                    $data[$key]->next_available = next_available_day($value->id);
                }

            } elseif ($request->search_for == 'dishes') {
                $user_id = request()->user()->id;
                //$data = get_product_with_variant_and_addons([['product_name', 'like', '%' . $request->keyword . '%'], ['products.status', '=', '1'], ['product_for', '=', '3']], $user_id, '', '', true);
                $product = Product_master::where('products.status', '=', '1')->where('products.product_approve', '=', '1')->where('product_for', '=', '3')->where('product_name', 'LIKE', '%' . $request->keyword . '%');
                $product->join('vendors', 'products.userId', '=', 'vendors.id');
                $product->leftJoin('user_vendor_like', function ($join) use ($user_id) {
                    $join->on('vendors.id', '=', 'user_vendor_like.vendor_id');
                    $join->where('user_vendor_like.user_id', '=', $user_id);
                });

                $product = $product->join('cuisines', 'products.cuisines', '=', 'cuisines.id');

                if ($user_id != '') {


                    $product = $product->leftJoin('user_product_like', function ($join) use ($user_id) {
                        $join->on('products.id', '=', 'user_product_like.product_id');
                        //$join->where('products.cuisines', '=', 'cuisines.id');
                        //$join->where('products.category', '=', 'categories.id');
                        $join->where('user_product_like.user_id', '=', $user_id);
                    });

                }
                //
                $product = $product->leftJoin('variants', 'variants.product_id', 'products.id')
                    ->leftJoin('addons', function ($join) {
                        $join->whereRaw(DB::raw("FIND_IN_SET(addons.id, products.addons)"));
                        $join->whereNull('addons.deleted_at');
                    });
                $product = $product->Select(DB::raw('products.userId as vendor_id'),
                    'variants.id as variant_id', 'variants.variant_name', 'variants.variant_price', 'preparation_time', 'chili_level', 'type',
                    'addons.id as addon_id', 'addons.addon', 'addons.price as addon_price',
                    'products.id as product_id', 'products.dis as description', 'products.product_name', 'product_price', 'dis', 'customizable',
                    DB::raw('CONCAT("' . asset('products') . '/", product_image) AS image'), 'cuisines.name as cuisinesName', 'dis as description',
                    'products.id as product_id', 'product_rating', 'dis', 'chili_level', 'primary_variant_name');
                $product = $product->addSelect(\DB::raw('if(user_vendor_like.user_id is not null, true, false)  as is_vendor_like'));
                $product = $product->addSelect('vendors.name as restaurantName', 'vendors.image as vendor_image', 'vendors.profile_image as vendor_profile_image', 'banner_image', 'review_count', 'deal_cuisines', 'fssai_lic_no', 'vendor_food_type', 'table_service');
                $product = $product->addSelect('user_product_like.user_id', DB::raw('if(user_product_like.user_id is not null, true, false)  as is_like'));
                $product = $product->skip(0)->take(5);
                $data    = $product->get();
                $cart    = \App\Models\Cart::where('user_id', $user_id)->first();
                if (count($data->toArray())) {
                    foreach ($data as $i => $p) {
                        $qty = 0;//dd("sdf");
                        if (isset($cart->id) && $cart->id != '') {

                            $cart_p = \App\Models\CartProduct::where('cart_id', $cart->id)->where('product_id', $p['product_id'])->selectRaw('SUM(product_qty) as product_qty')->groupBy('product_id')->get();
                            if (isset($cart_p[0]->product_qty))
                                $qty = $cart_p[0]->product_qty;
                        }

                        if (!isset($variant[$p['product_id']])) {
                            $variant[$p['product_id']]                    = ['product_id'           => $p['product_id'],
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
                            $variant[$p['product_id']] ['restaurantName'] = $p['restaurantName'];
                            $variant[$p['product_id']] ['vendor_image']   = asset('vendors') . $p['vendor_image'];
                            $banners                                      = json_decode($p['banner_image']);
                            if (is_array($banners))
                                $variant[$p['product_id']] ['banner_image'] = array_map(function ($banner) {
                                    return URL::to('vendor-banner/') . '/' . $banner;
                                }, $banners);
                            else
                                $variant[$p['product_id']] ['banner_image'] = [];


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
                $data = array_values($variant);
                //dd($product);


            } else {
                $data = [];
            }

            return response()->json([
                'status'   => true,
                'message'  => 'Data Get Successfully',
                'response' => $data

            ], 200);
        } catch (Throwable $th) {
            return response()->json([
                'status' => false,
                'error'  => $th->getMessage()
            ], 500);
        }
    }

// restaurant page
//
    public function chefHomePage(Request $request)
    {
        try {
            $validateUser = Validator::make(
                $request->all(),
                [
                    'lat' => 'required|numeric',
                    'lng' => 'required|numeric',
                ]
            );
            if ($validateUser->fails()) {
                $error = $validateUser->errors();
                return response()->json([
                    'status' => false,
                    'error'  => $validateUser->errors()->all()

                ], 401);
            }
            $select  = "( 3959 * acos( cos( radians($request->lat) ) * cos( radians( vendors.lat ) ) * cos( radians( vendors.long ) - radians($request->lng) ) + sin( radians($request->lat) ) * sin( radians( vendors.lat ) ) ) ) ";
            $vendors = Vendors::where(['status' => '1', 'vendor_type' => 'chef', 'is_all_setting_done' => '1']);
            $vendors = $vendors->select('vendors.id as chef_id', 'name', 'bio', 'dob', 'vendor_ratings', 'tax', 'fssai_lic_no', 'review_count', \DB::raw('CONCAT("' . asset('vendors') . '/", image) AS image'), \DB::raw('CONCAT("' . asset('vendor-profile') . '/", profile_image) AS profile_image'), \DB::raw("DATE_FORMAT(FROM_DAYS(DATEDIFF(now(),dob)), '%Y')+0 AS Age"), 'experience', \DB::raw("0 as order_served"), \DB::raw('if(user_vendor_like.user_id is not null, true, false)  as is_like'));
            $vendors = $vendors->selectRaw("ROUND({$select},1) AS distance");
            $vendors = $vendors->leftJoin('user_vendor_like', function ($join) {
                $join->on('vendors.id', '=', 'user_vendor_like.vendor_id');
                $join->where('user_vendor_like.user_id', '=', request()->user()->id);
            });
            $vendors = $vendors->addSelect(DB::raw('(SELECT name FROM cuisines WHERE  cuisines.id IN (vendors.speciality) ) AS food_specility'));
            $vendors = $vendors->orderBy('vendors.id', 'desc')->get();
//            $products = Product_master::where(['products.status' => '1', 'product_for' => '2'])->join('vendors', 'products.userId', '=', 'vendors.id')->select('products.product_name', 'product_price', 'customizable', \DB::raw('CONCAT("' . asset('products') . '/", product_image) AS image', 'vendors.name as restaurantName'))->orderBy('products.id', 'desc')->get();

            $products         = get_product_with_variant_and_addons(['products.status' => '1', 'product_for' => '2'], request()->user()->id, 'products.id', 'desc', false);
            $platform         = AdminMasters::select('platform_charges')->first();
            $platform_charges = $platform->platform_charges;
            return response()->json([
                'status'   => true,
                'message'  => 'Data Get Successfully',
                'response' => ['vendors' => $vendors, 'products' => $products, 'platform_charges' => $platform_charges]

            ], 200);
        } catch (Throwable $th) {
            return response()->json([
                'status' => false,
                'error'  => $th->getMessage()
            ], 500);
        }
    }

    public function getChefByCategory(Request $request)
    {
        try {
            $validateUser = Validator::make(
                $request->all(),
                [
                    'category_id' => 'required|numeric',
                    'lat'         => 'required|numeric',
                    'lng'         => 'required|numeric',
                ]
            );
            if ($validateUser->fails()) {
                $error = $validateUser->errors();
                return response()->json([
                    'status' => false,
                    'error'  => $validateUser->errors()->all()

                ], 401);
            }
            //$data = \App\Models\Product_master::distinct('userId')->select('userId','vendors.name','')->join('vendors','products.userId','=','vendors.id')->where(['products.status'=>'1','product_for'=>'3','category' => $request->category_id])->get();
            $select = "( 3959 * acos( cos( radians($request->lat) ) * cos( radians( vendors.lat ) ) * cos( radians( vendors.long ) - radians($request->lng) ) + sin( radians($request->lat) ) * sin( radians( vendors.lat ) ) ) ) ";
            $data   = Vendors::select('name', \DB::raw('CONCAT("' . asset('vendors') . '/", image) AS image'), \DB::raw("DATE_FORMAT(FROM_DAYS(DATEDIFF(now(),dob)), '%Y')+0 AS Age"), 'vendor_ratings', 'speciality', 'deal_categories', 'vendors.id as chef_id', 'experience', 'fssai_lic_no', \DB::raw("0 as order_served"), "vendor_food_type", "review_count", \DB::raw('if(user_vendor_like.user_id is not null, true, false)  as is_like'));
            $data   = $data->selectRaw("ROUND({$select},1) AS distance");
            $data   = $data->addSelect(DB::raw('(SELECT name FROM cuisines WHERE  cuisines.id IN (vendors.speciality) ) AS food_specility'));
            $data   = $data->where(['vendors.status' => '1', 'vendor_type' => 'chef', 'is_all_setting_done' => '1'])->whereRaw('FIND_IN_SET("' . $request->category_id . '",deal_categories)');
            $data   = $data->leftJoin('user_vendor_like', function ($join) {
                $join->on('vendors.id', '=', 'user_vendor_like.vendor_id');
                $join->where('user_vendor_like.user_id', '=', request()->user()->id);
            });
            $data   = $data->get();
            date_default_timezone_set('Asia/Kolkata');
            foreach ($data as $key => $value) {
                $category     = Catogory_master::whereIn('id', explode(',', $value->deal_categories))->pluck('name');
                $timeSchedule = VendorOrderTime::where(['vendor_id' => $value->chef_id, 'day_no' => Carbon::now()->dayOfWeek])->first();

                if ($timeSchedule->available) {
                    if (strtotime(date('H:i:s')) >= strtotime($timeSchedule->start_time) && strtotime(date('H:i:s')) <= strtotime($timeSchedule->end_time)) {
                        $data[$key]->isClosed = false;
                    } else {
                        $data[$key]->isClosed = true;
                    }
                } else {
                    $data[$key]->isClosed = true;
                }
                $data[$key]->categories = $category;
                $data[$key]->is_like    = true;
            }
            return response()->json([
                'status'   => true,
                'message'  => 'Data Get Successfully',
                'response' => $data

            ], 200);
        } catch (Throwable $th) {
            return response()->json([
                'status' => false,
                'error'  => $th->getMessage()
            ], 500);
        }
    }

    public function getChefDetailPage(Request $request)
    {
        try {
            $validateUser = Validator::make(
                $request->all(),
                [
                    'vendor_id' => 'required|numeric'
                ]
            );
            if ($validateUser->fails()) {
                $error = $validateUser->errors();
                return response()->json([
                    'status' => false,
                    'error'  => $validateUser->errors()->all()

                ], 401);
            }
            $category = Product_master::where(['userId' => $request->vendor_id])
                ->select('product_name', 'products.id as product_id', 'type', 'category', 'cuisines', 'product_price', 'customizable', \DB::raw('CONCAT("' . asset('products') . '/", product_image) AS image'), 'cuisines.name as cuisines_name', \DB::raw('if(user_product_like.user_id is not null, true, false)  as is_like'), 'product_rating')
                ->join('cuisines', 'products.cuisines', '=', 'cuisines.id')
                ->leftJoin('user_product_like', function ($join) {
                    $join->on('products.id', '=', 'user_product_like.product_id');
                    $join->where('user_product_like.user_id', '=', request()->user()->id);
                })
                ->get();

            return response()->json([
                'status'   => true,
                'message'  => 'Data Get Successfully',
                'response' => $category

            ], 200);
        } catch (Throwable $th) {
            return response()->json([
                'status' => false,
                'error'  => $th->getMessage()
            ], 500);
        }
    }

    public function getChefProfile(Request $request)
    {
        try {
            $validateUser = Validator::make(
                $request->all(),
                [
                    'vendor_id' => 'required|numeric'
                ]
            );
            if ($validateUser->fails()) {
                $error = $validateUser->errors();
                return response()->json([
                    'status' => false,
                    'error'  => $validateUser->errors()->all()

                ], 401);
            }

            $vendors = Vendors::where(['id' => $request->vendor_id, 'vendor_type' => 'chef']);

            $vendors = $vendors->select('name', \DB::raw('CONCAT("' . asset('vendors') . '/", image) AS image'), \DB::raw("DATE_FORMAT(FROM_DAYS(DATEDIFF(now(),dob)), '%Y')+0 AS Age"), 'vendor_ratings', 'speciality', 'deal_categories', 'id', 'experience', 'fssai_lic_no', 'bio')->first();

            $cuisines            = Cuisines::whereIn('id', explode(',', $vendors->speciality))->pluck('name');
            $vendors->speciality = $cuisines;
            $videos              = Chef_video::where('userId', '=', $request->vendor_id)->get();
            return response()->json([
                'status'   => true,
                'message'  => 'Data Get Successfully',
                'response' => ['profile' => $vendors, 'videos' => $videos]

            ], 200);
        } catch (Throwable $th) {
            return response()->json([
                'status' => false,
                'error'  => $th->getMessage()
            ], 500);
        }
    }

    /*
        public function add_to_cart(Request $request)
        {
            try {
                $validateUser = Validator::make(
                    $request->all(),
                    [
                        'user_id' => 'required|numeric',
                        'vendor_id' => 'required|numeric',
                        'products.*.product_id' => 'required|numeric',
                        'products.*.product_qty' => 'required|numeric',
                        'products.*.variants.*.variant_id' => 'numeric|nullable',
                        'products.*.variants.*.variant_qty' => 'string|nullable',
                        'products.*.addons.*.addon_id' => 'numeric|nullable',
                        'products.*.addons.*.addon_qty' => 'string|nullable',

                        // 'addons.*.id' => 'numeric|nullable',
                        // 'addons.*.addon_qty' => "numeric|nullable"
                    ]

                );
                if ($validateUser->fails()) {
                    $error = $validateUser->errors();
                    return response()->json(['status' => false, 'error' => $validateUser->errors()->all()], 401);
                }
                global $cart_id;
                try {
                    DB::beginTransaction();
                    // database queries here
                    $is_exist=Cart::where('user_id',$request->user_id)->first();
                    if(isset($is_exist->id)){
                        $error ='Another Cart is already exist.So that you can not create new one';
                        return response()->json(['status' => false, 'error' => $error], 401);
                    }

                    $cart_obj = new Cart($request->all());
                    $cart_obj->user_id = $request->user_id;
                    $cart_obj->vendor_id = $request->vendor_id;
                    $cart_obj->saveOrFail();
                    $cart_id = $cart_obj->id;
                    foreach ($request->products as $k => $p) {
                        $cart_products = new CartProduct($p);
                        $cart_obj->products()->save($cart_products);
                        if (isset($p['variants']))
                            foreach ($p['variants'] as $k => $v) {
                                $CartProductVariant = new CartProductVariant();
                                $CartProductVariant->cart_product_id = $cart_products->id;
                                $CartProductVariant->variant_id = $v['variant_id'];
                                $CartProductVariant->variant_qty = $v['variant_qty'];
                                $CartProductVariant->save();
                            }

                        if (isset($p['addons']))
                            foreach ($p['addons'] as $k => $a) {
                                $CartProductAddon = new CartProductAddon();
                                $CartProductAddon->cart_product_id = $cart_products->id;
                                $CartProductAddon->addon_id = $a['addon_id'];
                                $CartProductAddon->addon_qty = $a['addon_qty'];
                                $CartProductAddon->save();
                            }
                    }

                    DB::commit();

                    return response()->json(['status' => true, 'message' => 'Data Get Successfully', 'response' => ["cart_id" => $cart_id]], 200);
                } catch (PDOException $e) {
                    // Woopsy
                    DB::rollBack();
                    return response()->json(['status' => false, 'error' => $e->getMessage()], 500);
                }
            } catch (Throwable $th) {
                return response()->json(['status' => False, 'error' => $th->getMessage()], 500);
            }
        }


        public function empty_cart(Request $request)
        {
            try {
                $validateUser = Validator::make($request->all(), ['user_id' => 'required|numeric']);
                if ($validateUser->fails()) {
                    $error = $validateUser->errors();
                    return response()->json(['status' => false, 'error' => $validateUser->errors()->all()], 401);
                }
                global $cart_id;
                try {
                    DB::beginTransaction();
                    // database queries here

                    $cart_objs = Cart::where('user_id', $request->user_id)->get();
                    foreach ($cart_objs as $k => $cart_obj) {
                        $cart_obj->cart_product_variants()->delete();
                        $cart_obj->cart_product_addons()->delete();
                        $cart_obj->products()->delete();
                        $cart_obj->delete();
                    }
                    DB::commit();
                    return response()->json(['status' => true, 'message' => 'Data Get Successfully'], 200);
                } catch (PDOException $e) {
                    // Woopsy
                    DB::rollBack();
                    return response()->json(['status' => false, 'error' => $e->getMessage()], 500);
                }
            } catch (Throwable $th) {
                return response()->json(['status' => False, 'error' => $th->getMessage()], 500);
            }
        }


        public function view_cart(Request $request)
        {

            try {
                $validateUser = Validator::make($request->all(), [
                    'user_id' => 'required|numeric'
                ]);
                if ($validateUser->fails()) {
                    $error = $validateUser->errors();
                    return response()->json(['status' => false, 'error' => $validateUser->errors()->all()], 401);
                }

                \DB::enableQueryLog();
                $cart_users=Cart::where('user_id',$request->user_id)->first();
                if(!isset($cart_users->id))
                    return response()->json(['status' => false, 'error' => "your cart is empty"], 401);
                $cart_id = $cart_users->id;

                $e = Cart::where('id', $cart_id)->exists();
                if (!$e)
                    return response()->json(['status' => false, 'error' => 'Cart does not exists.'], 401);

                $wallet_amount = 0;
                $u = User::select('wallet_amount')->find($request->user_id);
                if (isset($u->wallet_amount))
                    $wallet_amount = $u->wallet_amount;


                $pro = Product_master::select('products.*')->where('status', 1)
                    ->whereIn(
                        "products.id",
                        function ($query) use ($cart_id) {
                            $query->select('product_id as product_id')->from('cart_products')->where('cart_id', $cart_id);
                        }
                    )
                    ->with(['product_variants', 'cuisines'])->get();

                if ($pro != null)
                    $pro = $pro->toArray();

                //SELECT * FROM `cart_product_variants`
                //LEFT JOIN cart_products on cart_products.id=cart_product_variants.cart_product_id
                //where cart_id=7
                $variants = CartProductVariant::select('*')
                    ->where('cart_products.cart_id', $cart_id)
                    ->join('cart_products', 'cart_products.id', '=', 'cart_product_variants.cart_product_id')
                    ->pluck('variant_qty', 'variant_id');
                if ($variants != null)
                    $variants = $variants->toArray();

                foreach ($pro as $k => $product) {
                    unset($pro[$k]['variants']);
                    unset($pro[$k]['created_at']);
                    unset($pro[$k]['updated_at']);
                    unset($pro[$k]['deleted_at']);
                    $pro[$k]['cuisines'] = $product['cuisines']['name'];
                    $pro[$k]['product_image'] = asset('products') . '/' . $product['product_image'];


                    if ($product['addons'] != '') {
                        $pro[$k]['addons'] = @Addons::select(DB::raw('distinct addons.id,addon_id, addon, price, addon_qty'))
                            // select('addon_id', 'addon', 'price', 'addon_qty')
                            ->whereIn('addons.id', explode(',', $product['addons']))
                            ->leftJoin('cart_product_addons', 'cart_product_addons.addon_id', '=', 'addons.id')
                            ->get()->toArray();
                    }
                    if (count($product['product_variants']) > 0) {
                        foreach ($product['product_variants'] as $k1 => $product_variants) {
                            unset($pro[$k]['product_variants'][$k1]['deleted_at']);
                            unset($pro[$k]['product_variants'][$k1]['created_at']);
                            unset($pro[$k]['product_variants'][$k1]['updated_at']);

                            if (isset($variants[$product_variants['id']]))
                                $pro[$k]['product_variants'][$k1]['variant_qty'] = $variants[$product_variants['id']];
                            else
                                $pro[$k]['product_variants'][$k1]['variant_qty'] = 0;
                        }
                    }
                }
                // dd($pro);
                //    dd(\DB::getQueryLog ());

                return response()->json(['status' => true, 'message' => 'Data Get Successfully', 'response' => ["cart" => $pro, 'wallet_amount' => $wallet_amount]], 200);
            } catch (Throwable $th) {
                return response()->json(['status' => False, 'error' => $th->getMessage()], 500);
            }
        }
    */
    public function add_to_like_vendor(Request $request)
    {
        try {

            $validateUser = Validator::make($request->all(), [
                'user_id'   => 'required|numeric',
                'vendor_id' => 'required|numeric'
            ]);
            UserVendorLike::updateOrCreate([
                'user_id'   => $request->user_id,
                'vendor_id' => $request->vendor_id
            ]);

            return response()->json([
                'status'   => true,
                'message'  => 'Liked Successfully',
                'response' => true

            ], 200);


        } catch (Throwable $th) {
            return response()->json([
                'status' => false,
                'error'  => $th->getMessage()
            ], 500);
        }
    }

    /* public function update_cart(Request $request)
     {
         try {
             $validateUser = Validator::make(
                 $request->all(),
                 [
                     'cart_id' => 'required|numeric',
                     'user_id' => 'required|numeric',
                     'vendor_id' => 'required|numeric',
                     'products.*.product_id' => 'required|numeric',
                     'products.*.product_qty' => 'required|numeric',
                     'products.*.variants.*.variant_id' => 'numeric|nullable',
                     'products.*.variants.*.variant_qty' => 'string|nullable',
                     'products.*.addons.*.addon_id' => 'numeric|nullable',
                     'products.*.addons.*.addon_qty' => 'string|nullable',
            ]

             );
             if ($validateUser->fails()) {
                 $error = $validateUser->errors();
                 return response()->json(['status' => false, 'error' => $validateUser->errors()->all()], 401);
             }
             global $cart_id;
             try {
                 \DB::enableQueryLog();
                 DB::beginTransaction();
                 // database queries here

                 $cart_obj = Cart::find($request->cart_id);
                 if (!$cart_obj) {
                     return response()->json(['status' => false, 'error' => 'Cart not found'], 401);
                 }

                 $cart_obj->user_id = $request->user_id;
                 $cart_obj->vendor_id = $request->vendor_id;
                 $cart_obj->saveOrFail();
                 $cart_id = $cart_obj->id;
                 foreach ($request->products as $k => $p) {
                     $cart_products = CartProduct::where('product_id', $p['product_id'])->where('cart_id', $cart_id)->first();


                     if (!$cart_products)
                         $cart_products = new CartProduct($p);
                     else {
                         $cart_products->product_id = $p['product_id'];
                         $cart_products->product_qty = $p['product_qty'];
                     }

                     $cart_obj->products()->save($cart_products);
                     $cart_products_id[] = $cart_products->id;
                     if (isset($p['variants'])) {
                         foreach ($p['variants'] as $k => $v) {
                             $CartProductVariant = CartProductVariant::where('cart_product_id', $cart_products->id)->where('variant_id', $v['variant_id'])->first();

                             if (!$CartProductVariant) {
                                 $CartProductVariant = new CartProductVariant();
                                 $CartProductVariant->cart_product_id = $cart_products->id;
                                 $CartProductVariant->variant_id = $v['variant_id'];
                             }
                             $CartProductVariant->variant_qty = $v['variant_qty'];
                             $CartProductVariant->save();
                             $cart_products_variant_id[] = $CartProductVariant->id;
                         }
                         $cart_obj->cart_product_variants()->whereNotIn('cart_product_variants.id', $cart_products_variant_id)->delete();
                     }
                     if (isset($p['addons']) && $p['addons'] != '')
                         foreach ($p['addons'] as $k => $a) {
                             $CartProductAddon = CartProductAddon::where('cart_product_id', $cart_products->id)->where('addon_id', $a['addon_id'])->first();
                             if (!$CartProductAddon) {
                                 $CartProductAddon = new CartProductAddon();
                                 $CartProductAddon->cart_product_id = $cart_products->id;
                                 $CartProductAddon->addon_id = $a['addon_id'];
                             }
                             $CartProductAddon->addon_qty = $a['addon_qty'];
                             $CartProductAddon->save();
                             $cart_products_addons_id[] = $CartProductAddon->id;
                         }
                     $cart_obj->cart_product_addons()->whereNotIn('cart_product_addons.id', $cart_products_addons_id)->delete();
                 }

                 $cart_obj->products()->whereNotIn('id', $cart_products_id)->delete();

                 DB::commit();

                 return response()->json(['status' => true, 'message' => 'Data Get Successfully', 'response' => ["cart_id" => $cart_id]], 200);
             } catch (PDOException $e) {
                 // Woopsy
                 DB::rollBack();
                 return response()->json(['status' => false, 'error' => $e->getMessage()], 500);
             }
         } catch (Throwable $th) {
             return response()->json(['status' => False, 'error' => $th->getMessage()], 500);
         }
     }
    */
    public function add_to_like_product(Request $request)
    {
        try {

            $validateUser = Validator::make($request->all(), [
                'user_id'    => 'required|numeric',
                'product_id' => 'required|numeric'
            ]);
            if ($validateUser->fails()) {
                $error = $validateUser->errors();
                return response()->json(['status' => false, 'error' => $validateUser->errors()->all()], 401);
            }
            UserProductLike::updateOrCreate([
                'user_id'    => $request->user_id,
                'product_id' => $request->product_id
            ]);

            return response()->json([
                'status'   => true,
                'message'  => 'Liked Successfully',
                'response' => true

            ], 200);


        } catch (Throwable $th) {
            return response()->json([
                'status' => false,
                'error'  => $th->getMessage()
            ], 500);
        }
    }

    public function add_to_like_product_chef(Request $request)
    {
        try {

            $validateUser = Validator::make($request->all(), [
                'user_id'    => 'required|numeric',
                'product_id' => 'required|numeric'
            ]);
            if ($validateUser->fails()) {
                $error = $validateUser->errors();
                return response()->json(['status' => false, 'error' => $validateUser->errors()->all()], 401);
            }
            UserProductLike::updateOrCreate([
                'user_id'    => $request->user_id,
                'product_id' => $request->product_id
            ]);

            return response()->json([
                'status'   => true,
                'message'  => 'Liked Successfully',
                'response' => true

            ], 200);


        } catch (Throwable $th) {
            return response()->json([
                'status' => false,
                'error'  => $th->getMessage()
            ], 500);
        }
    }

    public function create_order(Request $request)
    {
//        date_default_timezone_set(config('app.timezone'));
        try {
            $validateUser = Validator::make(
                $request->all(),
                [
                    'user_id'          => 'required|numeric',
                    'vendor_id'        => 'required|numeric',
                    'customer_name'    => 'required|string',
                    'delivery_address' => 'required|string',
                    'city'             => 'required|string',
                    'pincode'          => 'required|string',
                    'lat'              => 'required|string',
                    'long'             => 'required|string',

                    'total_amount'    => 'required|numeric',
                    'gross_amount'    => 'required|numeric',
                    'net_amount'      => 'required|numeric',
                    'wallet_apply'    => 'required',
                    'discount_amount' => 'required|numeric',
                    'coupon_id'       => 'nullable|numeric',
                    'payment_type'    => 'nullable|string',
                    'payment_status'  => 'nullable|string',
                    'transaction_id'  => 'nullable|string',
                    'payment_string'  => 'nullable|string',

                    'products.*.product_id'   => 'required|numeric',
                    'products.*.product_qty'  => 'required|numeric',
                    'products.*.product_name' => 'required|string',

                    'products.*.variants.*.variant_id'    => 'numeric|nullable',
                    'products.*.variants.*.variant_qty'   => 'numeric|nullable',
                    'products.*.variants.*.variant_price' => 'numeric|nullable',
                    'products.*.variants.*.variant_name'  => 'string|nullable',

                    'products.*.addons.*.addon_id'    => 'numeric|nullable',
                    'products.*.addons.*.addon_qty'   => 'numeric|nullable',
                    'products.*.addons.*.addon_price' => 'numeric|nullable',
                    'products.*.addons.*.addon_name'  => 'string|nullable',
                ]

            );
            if ($validateUser->fails()) {
                $error = $validateUser->errors();
                return response()->json(['status' => false, 'error' => $validateUser->errors()->all()], 401);
            }
            global $cart_id;
            try {
                DB::beginTransaction();

                if (!Vendors::is_avaliavle($request->vendor_id))
                    return response()->json(['status' => False, 'error' => "Vendor not available"], 401);
                $data = $request->all();
                $user = User::where('id', '=', $request->user_id)->first();
                if ($request->wallet_apply) {
                    if ($user->wallet_amount <= 0) {
                        return response()->json(['status' => False, 'error' => "No Wallet Balance available"], 401);
                    }
                    if ($user->wallet_amount <= $request->net_amount) {
                        $walletCut = $user->wallet_amount;
                        $available = 0;
                    } else {
                        $walletCut = $request->net_amount;
                        $available = $user->wallet_amount - $request->net_amount;
                    }
                    User::where('id', '=', $request->user_id)->update(['wallet_amount' => $available]);
                } else {
                    $walletCut = 0;
                }
                //
                if (is_array($request->payment_string))
                    $data['payment_string'] = serialize($request->payment_string);
                $insertData               = $request->all();
                $insertData['wallet_cut'] = $walletCut;
                $Order                    = new Order($insertData);
                $Order->saveOrFail();
                $order_id = $Order->id;
                foreach ($request->products as $k => $p) {
                    $order_products = new OrderProduct($p);
                    $Order->products()->save($order_products);
                    if (isset($p['variants']))
                        foreach ($p['variants'] as $k => $v) {
                            $orderProductVariant = new OrderProductVariant($v);
                            $order_products->order_product_variants()->save($orderProductVariant);
                        }

                    if (isset($p['addons']))
                        foreach ($p['addons'] as $k => $a) {
                            $OrderProductAddon = new OrderProductAddon($a);
                            $order_products->order_product_addons()->save($OrderProductAddon);
                        }
                }
                $riderAssign = new RiderAssignOrders(array('rider_id' => '1', 'order_id' => $order_id));
                $riderAssign->saveOrFail();
                DB::commit();

                event(new OrderCreateEvent($order_id, $request->user_id, $request->vendor_id));
                return response()->json(['status' => true, 'message' => 'Data Get Successfully', 'response' => ["order_id" => $order_id]], 200);
            } catch (PDOException $e) {
                // Woopsy
                DB::rollBack();
                return response()->json(['status' => false, 'error' => $e->getMessage()], 500);
            }
        } catch (Throwable $th) {
            return response()->json(['status'      => False,
                                     'error'       => $th->getMessage(),
                                     'error_trace' => $th->getTrace()
            ], 500);
        }
    }

    public function get_order(Request $request)
    {
        try {
            $validateUser = Validator::make(
                $request->all(),
                [
                    'order_for' => 'required|in:restaurant,chef,dineout',
                    'offset'    => 'required|numeric'
                ],
                [
                    "order_for.in"       => 'Order For Value Should be in restaurant or chef or dineout',
                    "order_for.required" => 'Order For is required'
                ]

            );
            if ($validateUser->fails()) {
                $error = $validateUser->errors();
                return response()->json(['status' => false, 'error' => $validateUser->errors()->all()], 401);
            }
            if ($request->order_for == 'restaurant') {
                $order = Order::where('user_id', '=', request()->user()->id);
                $order = $order->select(\DB::raw('CONCAT("' . asset('vendors') . '/", image) AS image'), 'orders.id as order_id', 'vendors.name as vendor_name', 'order_status', 'net_amount', 'payment_type', \DB::raw("DATE_FORMAT(orders.created_at, '%d %b %Y at %H:%i %p') as order_date"), 'delivery_address', 'orders.lat', 'orders.long', 'vendors.lat as vendor_lat', 'vendors.long as vendor_lng', 'vendors.fssai_lic_no', 'vendors.address as vendor_address');
                $order = $order->join('vendors', 'orders.vendor_id', '=', 'vendors.id');
                $order = $order->where('vendors.vendor_type', '=', 'restaurant');
                $order = $order->orderBy('orders.id', 'desc');
                $order = $order->skip($request->offset)->take(10);
                $order = $order->get();

                foreach ($order as $key => $value) {
                    $products = OrderProduct::where('order_id', '=', $value->order_id)->join('products', 'order_products.product_id', 'products.id')->select('product_id', 'order_products.product_name', 'order_products.product_price', 'product_qty', 'order_products.id as order_product_id')->get();
                    foreach ($products as $k => $v) {
                        $OrderProductAddon   = OrderProductAddon::where('order_product_id', '=', $v->order_product_id)->select('addon_name', 'addon_price', 'addon_qty')->get();
                        $OrderProductVariant = OrderProductVariant::where('order_product_id', '=', $v->order_product_id)->select('variant_name', 'variant_price', 'variant_qty')->first();
                        if (!empty($OrderProductVariant)) {
                            $products[$k]->variant = $OrderProductVariant;
                        }
                        if (!empty($OrderProductAddon->toArray())) {
                            $products[$k]->addons = $OrderProductAddon;
                        }

                    }
                    $order[$key]->products = $products;
                }

                return response()->json([
                    'status'   => true,
                    'message'  => 'data get Successfully',
                    'response' => $order

                ], 200);


            }
            if ($request->order_for == 'chef') {

            }
            if ($request->order_for == 'dineout') {

            }

        } catch (Throwable $th) {
            return response()->json(['status' => False,
                                     'error'  => $th->getMessage(),
            ], 500);
        }
    }


    public function deleteLikeProduct(Request $request)
    {
        try {

            $validateUser = Validator::make($request->all(), [
                'user_id'    => 'required|numeric',
                'product_id' => 'required|numeric'
            ]);
            if ($validateUser->fails()) {
                $error = $validateUser->errors();
                return response()->json(['status' => false, 'error' => $validateUser->errors()->all()], 401);
            }
            UserProductLike::where([
                'user_id'    => $request->user_id,
                'product_id' => $request->product_id
            ])->delete();

            return response()->json([
                'status'   => true,
                'message'  => 'Dislike Successfully',
                'response' => true

            ], 200);


        } catch (Throwable $th) {
            return response()->json([
                'status' => false,
                'error'  => $th->getMessage()
            ], 500);
        }
    }

    public function deleteLikeProductChef(Request $request)
    {
        try {

            $validateUser = Validator::make($request->all(), [
                'user_id'    => 'required|numeric',
                'product_id' => 'required|numeric'
            ]);
            if ($validateUser->fails()) {
                $error = $validateUser->errors();
                return response()->json(['status' => false, 'error' => $validateUser->errors()->all()], 401);
            }
            UserProductLike::where([
                'user_id'    => $request->user_id,
                'product_id' => $request->product_id
            ])->delete();

            return response()->json([
                'status'   => true,
                'message'  => 'Dislike Successfully',
                'response' => true

            ], 200);


        } catch (Throwable $th) {
            return response()->json([
                'status' => false,
                'error'  => $th->getMessage()
            ], 500);
        }
    }

    public function deleteLikeVendor(Request $request)
    {
        try {

            $validateUser = Validator::make($request->all(), [
                'user_id'   => 'required|numeric',
                'vendor_id' => 'required|numeric'
            ]);
            if ($validateUser->fails()) {
                $error = $validateUser->errors();
                return response()->json(['status' => false, 'error' => $validateUser->errors()->all()], 401);
            }
            UserVendorLike::where([
                'user_id'   => $request->user_id,
                'vendor_id' => $request->vendor_id
            ])->delete();

            return response()->json([
                'status'   => true,
                'message'  => 'Dislike Successfully',
                'response' => true

            ], 200);


        } catch (Throwable $th) {
            return response()->json([
                'status' => false,
                'error'  => $th->getMessage()
            ], 500);
        }
    }

    public function deleteLikeChef(Request $request)
    {
        try {

            $validateUser = Validator::make($request->all(), [
                'user_id'   => 'required|numeric',
                'vendor_id' => 'required|numeric'
            ]);
            if ($validateUser->fails()) {
                $error = $validateUser->errors();
                return response()->json(['status' => false, 'error' => $validateUser->errors()->all()], 401);
            }
            UserVendorLike::where([
                'user_id'   => $request->user_id,
                'vendor_id' => $request->vendor_id
            ])->delete();

            return response()->json([
                'status'   => true,
                'message'  => 'Dislike Successfully',
                'response' => true

            ], 200);


        } catch (Throwable $th) {
            return response()->json([
                'status' => false,
                'error'  => $th->getMessage()
            ], 500);
        }
    }

    public function getUserInfo(Request $request)
    {
        try {

            $user = User::where('id', '=', request()->user()->id)->select('id', 'name', 'email', 'alternative_number', DB::raw('CONCAT("' . asset('user-profile') . '/", image) AS image'))->first();
            return response()->json([
                'status'   => true,
                'message'  => 'Data get Successfully',
                'response' => $user

            ], 200);


        } catch (Throwable $th) {
            return response()->json([
                'status' => false,
                'error'  => $th->getMessage()
            ], 500);
        }
    }

    public function getReferAmmoun(Request $request)
    {
        try {
            $validateUser = Validator::make($request->all(), [
                'user_id' => 'required'
            ]);
            if ($validateUser->fails()) {
                $error = $validateUser->errors();
                return response()->json(['status' => false, 'error' => $validateUser->errors()->all()], 401);
            }
            $user = User::whare('id', request()->user()->id)->select('referralCode', 'by_earn')->get();

            return response()->json([
                'status'   => true,
                'message'  => 'User Updated Successfully',
                'response' => $user

            ], 200);


        } catch (Throwable $th) {
            return response()->json([
                'status' => false,
                'error'  => $th->getMessage()
            ], 500);
        }
    }

    public function getReferAmmount(Request $request)
    {
        try {
            $validateUser = Validator::make($request->all(), [
                'user_id' => 'required'
            ]);
            if ($validateUser->fails()) {
                $error = $validateUser->errors();
                return response()->json(['status' => false, 'error' => $validateUser->errors()->all()], 401);
            }
            $user = User::where('id', '=', request()->user()->id)->select('referralCode', 'by_earn')->get();
            return response()->json([
                'status'       => true,
                'message'      => 'User Updated Successfully',
                'respons'      => $user,
                'reff_message' => 'Get Rs 21 On Your First Order'

            ], 200);


        } catch (Throwable $th) {
            return response()->json([
                'status' => false,
                'error'  => $th->getMessage()
            ], 500);
        }
    }

    public function updateUserInfo(Request $request)
    {
        try {
            $validateUser = Validator::make($request->all(), [
                'name'               => 'required',
                'email'              => 'required',
                'alternative_number' => 'required',
            ]);
            if ($validateUser->fails()) {
                $error = $validateUser->errors();
                return response()->json(['status' => false, 'error' => $validateUser->errors()->all()], 401);
            }
            $user = User::find(request()->user()->id);
            if ($request->has('image')) {
                $filename = time() . '-image-' . rand(100, 999) . '.' . $request->image->extension();
                $request->image->move(public_path('user-profile'), $filename);
                // $filePath = $request->file('image')->storeAs('public/vendor_image',$filename);
                $user->image = $filename;
            }
            $user->save();
            $update = User::where('id', '=', request()->user()->id)->update(['name' => $request->name, 'email' => $request->email, 'alternative_number' => $request->alternative_number]);
            return response()->json([
                'status'  => true,
                'message' => 'User Updated Successfully'

            ], 200);


        } catch (Throwable $th) {
            return response()->json([
                'status' => false,
                'error'  => $th->getMessage()
            ], 500);
        }
    }

    public function getUserFavVendors(Request $request)
    {
        try {
            $validateUser = Validator::make(
                $request->all(),
                [
                    'lat' => 'required|numeric',
                    'lng' => 'required|numeric',

                ]
            );
            if ($validateUser->fails()) {
                $error = $validateUser->errors();
                return response()->json([
                    'status' => false,
                    'error'  => $validateUser->errors()->all()

                ], 401);
            }
            $vendors = UserVendorLike::where('vendor_id', '=', request()->user()->id);
            $select  = "( 3959 * acos( cos( radians($request->lat) ) * cos( radians( vendors.lat ) ) * cos( radians( vendors.long ) - radians($request->lng) ) + sin( radians($request->lat) ) * sin( radians( vendors.lat ) ) ) ) ";
            $userid  = request()->user()->id;
            $vendors = $vendors->join('vendors', 'user_vendor_like.vendor_id', '=', 'vendors.id');
            $vendors = $vendors->where(['vendors.status' => '1', 'vendor_type' => 'restaurant', 'is_all_setting_done' => '1']);
            $vendors = $vendors->select('name', \DB::raw('CONCAT("' . asset('vendors') . '/", image) AS image'), 'vendor_ratings', 'vendors.id', 'lat', 'long', 'deal_categories');
            $vendors = $vendors->selectRaw("ROUND({$select},1) AS distance");
            $vendors = $vendors->orderBy('vendors.id', 'desc')->get();

            return response()->json([
                'status'   => true,
                'message'  => 'data get Successfully',
                'response' => $vendors

            ], 200);


        } catch (Throwable $th) {
            return response()->json([
                'status' => false,
                'error'  => $th->getMessage()
            ], 500);
        }
    }

    public function getUerFaq()
    {
        try {
            $data = \App\Models\User_faq::all();
            return response()->json([
                'status'   => true,
                'message'  => 'Data Get Successfully',
                'response' => $data

            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'error'  => $th->getMessage()
            ], 500);
        }
    }

    public function getTACusers()
    {
        try {
            $data = \App\Models\Content_management::select('terms_conditions_user')->get();
            return response()->json([
                'status'   => true,
                'message'  => 'Data Get Successfully',
                'response' => $data

            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'error'  => $th->getMessage()
            ], 500);
        }
    }

    public function getUserPrivacyPolicy()
    {
        try {
            $data = \App\Models\Content_management::select('user_privacy_policy')->get();
            return response()->json([
                'status'   => true,
                'message'  => 'Data Get Successfully',
                'response' => $data

            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'error'  => $th->getMessage()
            ], 500);
        }
    }

    public function getUserCancellationPolicy()
    {
        try {
            $data = \App\Models\Content_management::select('refund_cancellation_user')->get();
            return response()->json([
                'status'   => true,
                'message'  => 'Data Get Successfully',
                'response' => $data

            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'error'  => $th->getMessage()
            ], 500);
        }
    }

    public function getAboutUs()
    {
        try {
            $data = \App\Models\AdminMasters::select('aboutus')->get();
            return response()->json([
                'status'   => true,
                'message'  => 'Data Get Successfully',
                'response' => $data

            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'error'  => $th->getMessage()
            ], 500);
        }
    }

    public function getSocialmedia()
    {
        try {
            $data = \App\Models\AdminMasters::select('facebook_link', 'instagram_link', 'youtube_link')->get();
            return response()->json([
                'status'   => true,
                'message'  => 'Data Get Successfully',
                'response' => $data

            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'error'  => $th->getMessage()
            ], 500);
        }
    }

    public
    function chelfleb_produst(Request $request)
    {
        try {
//            $validateUser = Validator::make(
//                $request->all(),
//                [
//                    'lat' => 'required|numeric',
//                    'lng' => 'required|numeric',
//                ]
//            );
//            if ($validateUser->fails()) {
//                $error = $validateUser->errors();
//                return response()->json([
//                    'status' => false,
//                    'error' => $validateUser->errors()->all()
//
//                ], 401);
//            }
            //$data['lat'] = 24.4637223;
            //$data['lng'] = 74.8866346;
            $userid   = request()->user()->id;
            $products = get_product_with_variant_and_addons('', $userid, 'products.id', 'desc', false, true);
//            dd(DB::getQueryLog());
//
//            dd($products);
//dd(Carbon::next());
            return response()->json([
                'status'   => true,
                'message'  => 'Data Get Successfully',
                'response' => ['products' => $products]

            ], 200);
        } catch (Throwable $th) {
            return response()->json([
                'status' => false,
                'error'  => $th->getMessage()
            ], 500);
        }
    }


    public function save_contact_us(Request $request)
    {
        try {
            $validateUser = Validator::make($request->all(),
                [
                    'subject'     => 'required',
                    'description' => 'required'
                ]);
            if ($validateUser->fails()) {
                $error = $validateUser->errors();
                return response()->json([
                    'status' => false,
                    'error'  => $validateUser->errors()->all()

                ], 401);
            }


            $ContactUs              = new ContactUs();
            $ContactUs->user_id     = auth()->user()->id;
            $ContactUs->subject     = $request->subject;
            $ContactUs->description = $request->description;
            $ContactUs->save();

            return response()->json([
                'status'  => true,
                'message' => 'Successfully'
            ], 200);


        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'error'  => $th->getMessage()
            ], 500);
        }
    }


    public function getAllLikeProducts(Request $request)
    {
        try {

            $validateUser = Validator::make(
                $request->all(),
                [
                    'lat' => 'required|numeric',
                    'lng' => 'required|numeric'
                ]
            );
            if ($validateUser->fails()) {
                $error = $validateUser->errors();
                return response()->json([
                    'status' => false,
                    'error'  => $validateUser->errors()->all()

                ], 401);
            }
            $where_vendor_in = get_restaurant_ids_near_me($request->lat, $request->lng, null, $request->user()->id, null, null);


            $product_ids = UserProductLike::where('user_id', $request->user()->id)->pluck('product_id');

            $data = get_product_with_variant_and_addons(null, $request->user()->id, $order_by_column = '', $order_by_order = '',
                $with_restaurant_name = false, $is_chefleb_product = false, $where_vendor_in,
                $offset = null, $limit = null, $return_total_count = false, $product_ids);

            return response()->json([
                'status'   => true,
                'message'  => 'Successfully',
                'products' => $data
            ], 200);


        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'error'  => $th->getMessage()
            ], 500);
        }
    }

    public function getAllLikerestaurants(Request $request)
    {
        try {
            $validateUser = Validator::make(
                $request->all(),
                [
                    'lat' => 'required|numeric',
                    'lng' => 'required|numeric'
                ]
            );
            if ($validateUser->fails()) {
                $error = $validateUser->errors();
                return response()->json([
                    'status' => false,
                    'error'  => $validateUser->errors()->all()

                ], 401);
            }
            $data       = [];
            $vendor_ids = UserVendorLike::where('user_id', $request->user()->id)->pluck('vendor_id');
            if (!empty($vendor_ids)) {
                $data = get_restaurant_near_me($request->lat, $request->lng, null, $request->user()->id, null, null)
                    ->addSelect('speciality')
                    ->whereIn('vendors.id', $vendor_ids)->get();
                foreach ($data as $key => $value) {
                    $data[$key]->cuisines       = Cuisines::whereIn('cuisines.id', explode(',', $value->deal_cuisines))->pluck('name');
                    $data[$key]->categories     = Catogory_master::whereIn('id', explode(',', $value->deal_categories))->pluck('name');
                    $data[$key]->next_available = next_available_day($value->id);
                }
            }

            return response()->json([
                'status'  => true,
                'message' => 'Successfully',
                'vendors' => $data
            ], 200);


        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'error'  => $th->getMessage()
            ], 500);
        }
    }

    public function getRestuarantBy(Request $request)
    {
        try {
            $validateUser = Validator::make(
                $request->all(),
                [
                    'lat'           => 'required|numeric',
                    'lng'           => 'required|numeric',
                    'vendor_offset' => 'required|numeric',
                    'vendor_limit'  => 'required|numeric',
                    "by"            => 'required',
                    "for"           => "required"
                ]
            );

            if ($validateUser->fails()) {
//                $error = $validateUser->errors();
                return response()->json([
                    'status' => false,
                    'error'  => $validateUser->errors()->all()

                ], 401);
            }
//            DB::enableQueryLog();

            $where   = ['vendor_type' => $request->for];
            $vendors = get_restaurant_near_me($request->lat, $request->lng, $where, $request->user()->id)
                ->join('orders', 'vendors.id', '=', 'orders.vendor_id')
                ->addSelect('deal_cuisines', 'vendors.id as vendor_id');


            if ($request->by == 'order') {
                $vendors->addSelect(DB::raw('COUNT(*) as order_count'))
                    ->groupBy('orders.vendor_id')
                    ->orderBy('order_count', 'desc');
            } else {
                $vendors->addSelect('vendor_ratings')
                    ->groupBy('orders.vendor_id')
                    ->orderBy('vendor_ratings', 'desc');
            }
            $data = $vendors->offset($request->vendor_offset)->limit($request->vendor_limit)->get();


            foreach ($data as $key => $value) {
                $data[$key]->cuisines       = Cuisines::whereIn('cuisines.id', explode(',', $value->deal_cuisines))->pluck('name');
                $data[$key]->categories     = Catogory_master::whereIn('id', explode(',', $value->deal_categories))->pluck('name');
                $data[$key]->next_available = next_available_day($value->id);
            }


            return response()->json([
                'status'  => true,
                'message' => 'Successfully',
                'vendors' => $data
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'error'  => $th->getTrace()
            ], 500);
        }

    }

    public function cancel_order(Request $request)
    {
        try {
            $validateUser = Validator::make(
                $request->all(),
                [
                    'isCancelledWithin30Second' => 'required|in:1,0',
                    'order_id'                  => 'required|numeric'
                ]
            );
            if ($validateUser->fails()) {
                $error = $validateUser->errors();
                return response()->json(['status' => false, 'error' => $validateUser->errors()->all()], 401);
            }

            $order = Order::where('id', $request->order_id)
                ->where('user_id', $request->user()->id)
                ->first();
//            dd($order->id);
            if (!isset($order->id))
                return response()->json(['status' => false, 'error' => "order not found.You can only cancel orders placed by you."], 401);

            $order->order_status = 'cancelled_by_customer';
            $order->save();

            $user                = User::find($request->user()->id);
            $user->wallet_amount -= $order->net_amount;
            $user->save();

            return response()->json([
                'status'  => true,
                'message' => 'Successfully'
            ], 200);


        } catch (Throwable $th) {
            return response()->json(['status' => False,
                                     'error'  => $th->getMessage(),
            ], 500);
        }
    }
    // public function getTryonce(Request $request){
    //     try {

    // <<<<<<< HEAD
    //         $validateUser = Validator::make($request->all(), [
    //             'user_id' => 'required|numeric',
    //         ]);
    //         if ($validateUser->fails()) {
    //             $error = $validateUser->errors();
    //             return response()->json(['status' => false, 'error' => $validateUser->errors()->all()], 401);
    //         }
    //         $order = Order::where('user_id', '=', $request->user_id);
    //         $order = $order->select(\DB::raw('CONCAT("' . asset('vendors') . '/", image) AS image'),  'vendors.name as vendor_name','vendors.id as vendor_id','vendors.id as vendor_food_type','vendors.deal_categories as categories','vendors.deal_cuisines as cuisines',\DB::raw('CONCAT("' . asset('vendor-banner') . '/", vendors.banner_image) AS banner_image'));
    //         $order = $order->join('vendors', 'orders.vendor_id', '=', 'vendors.id');
    //         $order = $order->orderBy('orders.id', 'desc');
    //         $order = $order->skip($request->offset)->take(10);
    //         $order = $order->get();
    //         return response()->json([
    //             'status' => true,
    //             'message' => 'data get Successfully',
    //             'response' => $order

    //         ], 200);


    //     } catch (Throwable $th) {
    //         return response()->json([
    //             'status' => false,
    //             'error' => $th->getMessage()
    //         ], 500);
    //     }
    // }
    // public function filterByRestaurant(Request $request){
    //     try {
    //         $validateUser = Validator::make(
    //             $request->all(),
    //             [
    //                 'lat' => 'required|numeric',
    //                 'lng' => 'required|numeric',
    //             ]
    //         );
    //         if ($validateUser->fails()) {
    //             $error = $validateUser->errors();
    //             return response()->json([
    //                 'status' => false,
    //                 'error' => $validateUser->errors()->all()

    //             ], 401);
    //         }
    //         if($request->value == '1'){
    //             $userid = request()->user()->id;

    //             $where = [ 'vendor_type' => 'restaurant'];
    //             $vendors = get_restaurant_near_me($request->lat, $request->lng,$where, request()->user()->id);
    //             $vendors = $vendors->orderBy('vendors.id', 'desc')->get();
    //             $vendor_ids=get_restaurant_ids_near_me($request->lat, $request->lng, $where, false);
    //            // $products=get_product_with_variant_and_addons(['product_for' => '3'], request()->user()->id, 'products.id', 'desc',true,false,$vendor_ids);

    //             foreach ($vendors as $key => $value) {
    //                 $category = Catogory_master::whereIn('id', explode(',', $value->deal_categories))->pluck('name');
    //                 $vendors[$key]->categories = $category;
    //             }

    //             return response()->json([
    //                 'status' => true,
    //                 'message' => 'Data Get Successfully',
    //                 'response' => ['vendors' => $vendors]

    //             ], 200);
    //         }
    //         if($request->value == '2'){
    //             $userid = request()->user()->id;

    //             $where = [ 'vendor_type' => 'restaurant'];
    //             $vendors = get_restaurant_near_me($request->lat, $request->lng,$where, request()->user()->id);
    //             $vendors = $vendors->orderBy('vendors.id', 'desc')->get();
    //             $vendor_ids=get_restaurant_ids_near_me($request->lat, $request->lng, $where, false);
    //            // $products=get_product_with_variant_and_addons(['product_for' => '3'], request()->user()->id, 'products.id', 'desc',true,false,$vendor_ids);

    //             foreach ($vendors as $key => $value) {
    //                 $category = Catogory_master::whereIn('id', explode(',', $value->deal_categories))->pluck('name');
    //                 $vendors[$key]->categories = $category;
    //             }

    //             return response()->json([
    //                 'status' => true,
    //                 'message' => 'Data Get Successfully',
    //                 'response' => ['vendors' => $vendors]

    //             ], 200);
    //         }
    //         if($request->value == '3'){
    //             $userid = request()->user()->id;

    //             $where = [ 'vendor_type' => 'restaurant'];
    //             $where = [ 'vendor_food_type' => '1'];
    //             $vendors = get_restaurant_near_me_filertyrestourant($request->lat, $request->lng,$where, request()->user()->id);
    //             $vendors = $vendors->orderBy('vendors.id', 'desc')->get();
    //             $vendor_ids=get_restaurant_ids_near_me($request->lat, $request->lng, $where, false);
    //            // $products=get_product_with_variant_and_addons(['product_for' => '3'], request()->user()->id, 'products.id', 'desc',true,false,$vendor_ids);

    //             foreach ($vendors as $key => $value) {
    //                 $category = Catogory_master::whereIn('id', explode(',', $value->deal_categories))->pluck('name');
    //                 $vendors[$key]->categories = $category;
    //             }

    //             return response()->json([
    //                 'status' => true,
    //                 'message' => 'Data Get Successfully',
    //                 'response' => ['vendors' => $vendors]

    //             ], 200);
    //         }
    //         if($request->value == '4'){
    //             $userid = request()->user()->id;

    //             $where = [ 'vendor_type' => 'restaurant'];
    //             $where = [ 'vendor_food_type' => '3'];
    //             $vendors = get_restaurant_filerty_nonveg($request->lat, $request->lng,$where, request()->user()->id);
    //             $vendors = $vendors->orderBy('vendors.id', 'desc')->get();
    //             $vendor_ids=get_restaurant_ids_near_me($request->lat, $request->lng, $where, false);
    //            // $products=get_product_with_variant_and_addons(['product_for' => '3'], request()->user()->id, 'products.id', 'desc',true,false,$vendor_ids);

    //             foreach ($vendors as $key => $value) {
    //                 $category = Catogory_master::whereIn('id', explode(',', $value->deal_categories))->pluck('name');
    //                 $vendors[$key]->categories = $category;
    //             }

    //             return response()->json([
    //                 'status' => true,
    //                 'message' => 'Data Get Successfully',
    //                 'response' => ['vendors' => $vendors]

    //             ], 200);
    //         }

    //     } catch (Throwable $th) {
    //         return response()->json([
    //             'status' => false,
    //             'error' => $th->getMessage(),
    //             'errortrace' => $th->getTrace()
    //         ], 500);
    //     }
    // }
    // public function filterByChef(Request $request){
    //     try {
    //         $validateUser = Validator::make(
    //             $request->all(),
    //             [
    //                 'lat' => 'required|numeric',
    //                 'lng' => 'required|numeric',
    //             ]
    //         );
    //         if ($validateUser->fails()) {
    //             $error = $validateUser->errors();
    //             return response()->json([
    //                 'status' => false,
    //                 'error' => $validateUser->errors()->all()

    //             ], 401);
    //         }
    //         if($request->value == '1'){
    //             $userid = request()->user()->id;

    //             $where = [ 'vendor_type' => 'chef'];
    //             $vendors = get_restaurant_near_me($request->lat, $request->lng,$where, request()->user()->id);
    //             $vendors = $vendors->orderBy('vendors.id', 'desc')->get();
    //             $vendor_ids=get_restaurant_ids_near_me($request->lat, $request->lng, $where, false);
    //            // $products=get_product_with_variant_and_addons(['product_for' => '3'], request()->user()->id, 'products.id', 'desc',true,false,$vendor_ids);

    //             foreach ($vendors as $key => $value) {
    //                 $category = Catogory_master::whereIn('id', explode(',', $value->deal_categories))->pluck('name');
    //                 $vendors[$key]->categories = $category;
    //             }

    //             return response()->json([
    //                 'status' => true,
    //                 'message' => 'Data Get Successfully',
    //                 'response' => ['vendors' => $vendors]

    //             ], 200);
    //         }
    //         if($request->value == '2'){
    //             $userid = request()->user()->id;

    //             $where = [ 'vendor_type' => 'restaurant'];
    //             $vendors = get_restaurant_near_me($request->lat, $request->lng,$where, request()->user()->id);
    //             $vendors = $vendors->orderBy('vendors.id', 'desc')->get();
    //             $vendor_ids=get_restaurant_ids_near_me($request->lat, $request->lng, $where, false);
    //            // $products=get_product_with_variant_and_addons(['product_for' => '3'], request()->user()->id, 'products.id', 'desc',true,false,$vendor_ids);

    //             foreach ($vendors as $key => $value) {
    //                 $category = Catogory_master::whereIn('id', explode(',', $value->deal_categories))->pluck('name');
    //                 $vendors[$key]->categories = $category;
    //             }

    //             return response()->json([
    //                 'status' => true,
    //                 'message' => 'Data Get Successfully',
    //                 'response' => ['vendors' => $vendors]

    //             ], 200);
    //         }
    //         if($request->value == '3'){
    //             $userid = request()->user()->id;

    //             $where = [ 'vendor_type' => 'restaurant'];
    //             $where = [ 'vendor_food_type' => '1'];
    //             $vendors = get_restaurant_near_me_filertyrestourant($request->lat, $request->lng,$where, request()->user()->id);
    //             $vendors = $vendors->orderBy('vendors.id', 'desc')->get();
    //             $vendor_ids=get_restaurant_ids_near_me($request->lat, $request->lng, $where, false);
    //            // $products=get_product_with_variant_and_addons(['product_for' => '3'], request()->user()->id, 'products.id', 'desc',true,false,$vendor_ids);

    //             foreach ($vendors as $key => $value) {
    //                 $category = Catogory_master::whereIn('id', explode(',', $value->deal_categories))->pluck('name');
    //                 $vendors[$key]->categories = $category;
    //             }

    //             return response()->json([
    //                 'status' => true,
    //                 'message' => 'Data Get Successfully',
    //                 'response' => ['vendors' => $vendors]

    //             ], 200);
    //         }
    //         if($request->value == '4'){
    //             $userid = request()->user()->id;

    //             $where = [ 'vendor_type' => 'restaurant'];
    //             $where = [ 'vendor_food_type' => '3'];
    //             $vendors = get_restaurant_filerty_nonveg($request->lat, $request->lng,$where, request()->user()->id);
    //             $vendors = $vendors->orderBy('vendors.id', 'desc')->get();
    //             $vendor_ids=get_restaurant_ids_near_me($request->lat, $request->lng, $where, false);
    //            // $products=get_product_with_variant_and_addons(['product_for' => '3'], request()->user()->id, 'products.id', 'desc',true,false,$vendor_ids);

    //             foreach ($vendors as $key => $value) {
    //                 $category = Catogory_master::whereIn('id', explode(',', $value->deal_categories))->pluck('name');
    //                 $vendors[$key]->categories = $category;
    //             }

    //             return response()->json([
    //                 'status' => true,
    //                 'message' => 'Data Get Successfully',
    //                 'response' => ['vendors' => $vendors]

    //             ], 200);
    //         }

    //     } catch (Throwable $th) {
    //         return response()->json([
    //             'status' => false,
    //             'error' => $th->getMessage(),
    //             'errortrace' => $th->getTrace()
    //         ], 500);
    //     }
    // }
    public function filterByRestaurant(Request $request)
    {
        try {
            $validateUser = Validator::make(
                $request->all(),
                [
                    'lat' => 'required|numeric',
                    'lng' => 'required|numeric',
                ]
            );
            if ($validateUser->fails()) {
                $error = $validateUser->errors();
                return response()->json([
                    'status' => false,
                    'error'  => $validateUser->errors()->all()

                ], 401);
            }
            if ($request->value == '1') {
                $userid = request()->user()->id;

                $where      = ['vendor_type' => 'restaurant'];
                $vendors    = get_restaurant_near_me($request->lat, $request->lng, $where, request()->user()->id);
                $vendors    = $vendors->orderBy('vendors.id', 'desc')->get();
                $vendor_ids = get_restaurant_ids_near_me($request->lat, $request->lng, $where, false);
                // $products=get_product_with_variant_and_addons(['product_for' => '3'], request()->user()->id, 'products.id', 'desc',true,false,$vendor_ids);

                foreach ($vendors as $key => $value) {
                    $category                  = Catogory_master::whereIn('id', explode(',', $value->deal_categories))->pluck('name');
                    $vendors[$key]->categories = $category;
                }

                return response()->json([
                    'status'   => true,
                    'message'  => 'Data Get Successfully',
                    'response' => ['vendors' => $vendors]

                ], 200);
            }
            if ($request->value == '2') {
                $userid = request()->user()->id;

                $where      = ['vendor_type' => 'restaurant'];
                $vendors    = get_restaurant_near_me($request->lat, $request->lng, $where, request()->user()->id);
                $vendors    = $vendors->orderBy('vendors.id', 'desc')->get();
                $vendor_ids = get_restaurant_ids_near_me($request->lat, $request->lng, $where, false);
                // $products=get_product_with_variant_and_addons(['product_for' => '3'], request()->user()->id, 'products.id', 'desc',true,false,$vendor_ids);

                foreach ($vendors as $key => $value) {
                    $category                  = Catogory_master::whereIn('id', explode(',', $value->deal_categories))->pluck('name');
                    $vendors[$key]->categories = $category;
                }

                return response()->json([
                    'status'   => true,
                    'message'  => 'Data Get Successfully',
                    'response' => ['vendors' => $vendors]

                ], 200);
            }
            if ($request->value == '3') {
                $userid = request()->user()->id;

                $where      = ['vendor_type' => 'restaurant'];
                $where      = ['vendor_food_type' => '1'];
                $vendors    = get_restaurant_near_me_filertyrestourant($request->lat, $request->lng, $where, request()->user()->id);
                $vendors    = $vendors->orderBy('vendors.id', 'desc')->get();
                $vendor_ids = get_restaurant_ids_near_me($request->lat, $request->lng, $where, false);
                // $products=get_product_with_variant_and_addons(['product_for' => '3'], request()->user()->id, 'products.id', 'desc',true,false,$vendor_ids);

                foreach ($vendors as $key => $value) {
                    $category                  = Catogory_master::whereIn('id', explode(',', $value->deal_categories))->pluck('name');
                    $vendors[$key]->categories = $category;
                }

                return response()->json([
                    'status'   => true,
                    'message'  => 'Data Get Successfully',
                    'response' => ['vendors' => $vendors]

                ], 200);
            }
            if ($request->value == '4') {
                $userid = request()->user()->id;

                $where      = ['vendor_type' => 'restaurant'];
                $where      = ['vendor_food_type' => '3'];
                $vendors    = get_restaurant_filerty_nonveg($request->lat, $request->lng, $where, request()->user()->id);
                $vendors    = $vendors->orderBy('vendors.id', 'desc')->get();
                $vendor_ids = get_restaurant_ids_near_me($request->lat, $request->lng, $where, false);
                // $products=get_product_with_variant_and_addons(['product_for' => '3'], request()->user()->id, 'products.id', 'desc',true,false,$vendor_ids);

                foreach ($vendors as $key => $value) {
                    $category                  = Catogory_master::whereIn('id', explode(',', $value->deal_categories))->pluck('name');
                    $vendors[$key]->categories = $category;
                }

                return response()->json([
                    'status'   => true,
                    'message'  => 'Data Get Successfully',
                    'response' => ['vendors' => $vendors]

                ], 200);
            }

        } catch (Throwable $th) {
            return response()->json([
                'status'     => false,
                'error'      => $th->getMessage(),
                'errortrace' => $th->getTrace()
            ], 500);
        }
    }
}
