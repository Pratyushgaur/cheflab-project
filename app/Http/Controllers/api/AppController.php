<?php

namespace App\Http\Controllers\api;

use App\Events\OrderCreateEvent;
use App\Http\Controllers\Controller;
use App\Models\Addons;
use App\Models\Cart;
use App\Models\CartProduct;
use App\Models\CartProductAddon;
use App\Models\CartProductVariant;
use App\Models\Catogory_master;
use App\Models\Chef_video;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\OrderProductAddon;
use App\Models\OrderProductVariant;
use App\Models\Product_master;
use App\Models\User;
use App\Models\Variant;
use App\Models\VendorMenus;
use App\Models\VendorOrderTime;
use App\Models\Vendors;
use App\Models\UserProductLike;
use App\Models\UserVendorLike;
use App\Models\Cuisines;
use App\Models\Coupon;



use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDOException;
use Throwable;
use URL;
use Validator;

class AppController extends Controller
{

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
    //
    function calculateDistanceBetweenTwoAddresses($lat1, $lng1, $lat2, $lng2){
        $lat1 = deg2rad($lat1);
        $lng1 = deg2rad($lng1);

        $lat2 = deg2rad($lat2);
        $lng2 = deg2rad($lng2);

        $delta_lat = $lat2 - $lat1;
        $delta_lng = $lng2 - $lng1;

        $hav_lat = (sin($delta_lat / 2))**2;
        $hav_lng = (sin($delta_lng / 2))**2;

        $distance = 2 * asin(sqrt($hav_lat + cos($lat1) * cos($lat2) * $hav_lng));

        $distance = 3959*$distance;
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
                    'lat' => 'required|numeric',
                    'lng' => 'required|numeric',
                ]
            );
            if ($validateUser->fails()) {
                $error = $validateUser->errors();
                return response()->json([
                    'status' => false,
                    'error' => $validateUser->errors()->all()

                ], 401);
            }
            //$data['lat'] = 24.4637223;
            //$data['lng'] = 74.8866346;
            $select = "( 3959 * acos( cos( radians($request->lat) ) * cos( radians( vendors.lat ) ) * cos( radians( vendors.long ) - radians($request->lng) ) + sin( radians($request->lat) ) * sin( radians( vendors.lat ) ) ) ) ";
            $userid = request()->user()->id;
            $vendors = Vendors::where(['status' => '1', 'vendor_type' => 'restaurant', 'is_all_setting_done' => '1'])->select('name', \DB::raw('CONCAT("' . asset('vendors') . '/", image) AS image'), 'vendor_ratings','vendors.id','lat','long','deal_categories',\DB::raw('if(user_vendor_like.user_id is not null, true, false)  as is_like') )->selectRaw("ROUND({$select},1) AS distance");
            $vendors = $vendors->leftJoin('user_vendor_like',function($join){
                $join->on('vendors.id', '=', 'user_vendor_like.vendor_id');
                $join->where('user_vendor_like.user_id', '=',request()->user()->id );
            });
            $vendors = $vendors->orderBy('vendors.id', 'desc')->get();
            $products = Product_master::where(['products.status' => '1', 'product_for' => '3'])->join('vendors', 'products.userId', '=', 'vendors.id')->select('products.product_name', 'product_price', 'customizable', \DB::raw('CONCAT("' . asset('products') . '/", product_image) AS image'),'vendors.name as restaurantName','products.id',\DB::raw('if(user_product_like.user_id is not null, true, false)  as is_like'));
            $products = $products->leftJoin('user_product_like',function($join){
                $join->on('products.id', '=', 'user_product_like.product_id');
                $join->where('user_product_like.user_id', '=',request()->user()->id );
            });
            $products = $products->orderBy('products.id', 'desc')->get();
            foreach ($vendors as $key => $value) {
                $category = Catogory_master::whereIn('id', explode(',', $value->deal_categories))->pluck('name');
                $vendors[$key]->categories = $category;
            }

            return response()->json([
                'status' => true,
                'message' => 'Data Get Successfully',
                'response' => ['vendors' => $vendors, 'products' => $products]

            ], 200);
        } catch (Throwable $th) {
            return response()->json([
                'status' => false,
                'error' => $th->getMessage()
            ], 500);
        }
    }

    public function getRestaurantByCategory(Request $request)
    {
        try {
            $validateUser = Validator::make(
                $request->all(),
                [
                    'category_id' => 'required|numeric',
                    'lat' => 'required|numeric',
                    'lng' => 'required|numeric',

                ]
            );
            if ($validateUser->fails()) {
                $error = $validateUser->errors();
                return response()->json([
                    'status' => false,
                    'error' => $validateUser->errors()->all()

                ], 401);
            }
            //$data = \App\Models\Product_master::distinct('userId')->select('userId','vendors.name','')->join('vendors','products.userId','=','vendors.id')->where(['products.status'=>'1','product_for'=>'3','category' => $request->category_id])->get();
            $select = "( 3959 * acos( cos( radians($request->lat) ) * cos( radians( vendors.lat ) ) * cos( radians( vendors.long ) - radians($request->lng) ) + sin( radians($request->lat) ) * sin( radians( vendors.lat ) ) ) ) ";
            $data = Vendors::select('name', \DB::raw('CONCAT("' . asset('vendors') . '/", image) AS image'), 'banner_image', 'vendor_ratings', 'vendor_food_type', 'deal_categories', 'id', 'fssai_lic_no','table_service');
            $data = $data->where(['vendors.status' => '1', 'vendor_type' => 'restaurant', 'is_all_setting_done' => '1'])->whereRaw('FIND_IN_SET("' . $request->category_id . '",deal_categories)');
            $data = $data->selectRaw("ROUND({$select},1) AS distance");
            $data = $data->get();
            date_default_timezone_set('Asia/Kolkata');
            $baseurl = URL::to('vendor-banner/') . '/';
            foreach ($data as $key => $value) {

                $banners = json_decode($value->banner_image);
                $urlbanners = array_map(function ($banner) {
                    return URL::to('vendor-banner/') . '/' . $banner;
                }, $banners);

                $category = Catogory_master::whereIn('id', explode(',', $value->deal_categories))->pluck('name');
                $timeSchedule = VendorOrderTime::where(['vendor_id' => $value->id, 'day_no' => Carbon::now()->dayOfWeek])->first();
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
                $data[$key]->is_like = true;
                $data[$key]->imageUrl = $baseurl;
                $data[$key]->banner_image = $urlbanners;
            }
            return response()->json([
                'status' => true,
                'message' => 'Data Get Successfully',
                'response' => $data

            ], 200);
        } catch (Throwable $th) {
            return response()->json([
                'status' => false,
                'error' => $th->getMessage()
            ], 500);
        }
    }
    public function getRestaurantByCuisines(Request $request)
    {
        try {
            $validateUser = Validator::make(
                $request->all(),
                [
                    'cuisines_id' => 'required|numeric',
                    'lat' => 'required|numeric',
                    'lng' => 'required|numeric',
                ]
            );
            if ($validateUser->fails()) {
                $error = $validateUser->errors();
                return response()->json([
                    'status' => false,
                    'error' => $validateUser->errors()->all()

                ], 401);
            }
            //$data = \App\Models\Product_master::distinct('userId')->select('userId','vendors.name','')->join('vendors','products.userId','=','vendors.id')->where(['products.status'=>'1','product_for'=>'3','category' => $request->category_id])->get();
            $select = "( 3959 * acos( cos( radians($request->lat) ) * cos( radians( vendors.lat ) ) * cos( radians( vendors.long ) - radians($request->lng) ) + sin( radians($request->lat) ) * sin( radians( vendors.lat ) ) ) ) ";
            $data = Vendors::select('name', \DB::raw('CONCAT("' . asset('vendors') . '/", image) AS image'), 'banner_image', 'vendor_ratings', 'vendor_food_type', 'deal_categories', 'id', 'fssai_lic_no','table_service');
            $data = $data->where(['vendors.status' => '1', 'vendor_type' => 'restaurant', 'is_all_setting_done' => '1'])->whereRaw('FIND_IN_SET("' . $request->cuisines_id . '",deal_cuisines)');
            $data = $data->selectRaw("ROUND({$select},1) AS distance");
            $data = $data->get();
            date_default_timezone_set('Asia/Kolkata');
            $baseurl = URL::to('vendor-banner/') . '/';
            foreach ($data as $key => $value) {

                $banners = json_decode($value->banner_image);
                $urlbanners = array_map(function ($banner) {
                    return URL::to('vendor-banner/') . '/' . $banner;
                }, $banners);

                $category = Catogory_master::whereIn('id', explode(',', $value->deal_categories))->pluck('name');
                $timeSchedule = VendorOrderTime::where(['vendor_id' => $value->id, 'day_no' => Carbon::now()->dayOfWeek])->first();
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
                $data[$key]->is_like = true;
                $data[$key]->imageUrl = $baseurl;
                $data[$key]->banner_image = $urlbanners;
            }
            return response()->json([
                'status' => true,
                'message' => 'Data Get Successfully',
                'response' => $data

            ], 200);
        } catch (Throwable $th) {
            return response()->json([
                'status' => false,
                'error' => $th->getMessage()
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
                    'error' => $validateUser->errors()->all()

                ], 401);
            }
            $category = VendorMenus::where(['vendor_id' => $request->vendor_id])->select('menuName', 'id')->get();
            $date = today()->format('Y-m-d');
            $coupon =  Coupon::where('vendor_id', '=', $request->vendor_id)->where('status', '=',1)->where('from', '<=',$date)->where('to', '>=',$date)->select('*')->get();
            $catData = [];

            foreach ($category as $key => $value) {
                $product = Product_master::where(['products.status' => '1', 'product_for' => '3']);
                $product = $product->join('categories', 'products.category', '=', 'categories.id');
                $product = $product->leftJoin('user_product_like',function($join){
                    $join->on('products.id', '=', 'user_product_like.product_id');
                    $join->where('user_product_like.user_id', '=',request()->user()->id );
                });
                $product = $product->where('menu_id', '=', $value->id);
                $product = $product->select(
//                    'addons.*','addons.price as addon_price','addons.id as addon_id','addons.addon as addon_name',
                    'variants.id as variant_id','variants.variant_price','variants.variant_name',
                    'products.product_name', 'product_price', 'customizable','products.addons',
                    \DB::raw('CONCAT("' . asset('products') . '/", product_image) AS image'),'type','products.id as product_id','product_rating','categories.name as categoryName',\DB::raw('if(user_product_like.user_id is not null, true, false)  as is_like'));
                $product = $product->leftJoin('variants','variants.product_id','products.id');
//                $product = $product->leftJoin("addons", \DB::raw("FIND_IN_SET(addons, addons.id)"), ">", \DB::raw("'0'"));
//                $product = $product->leftJoin("addons",function($q){
//                    $q->whereRaw(\DB::raw("FIND_IN_SET(addons, addons.id)"));
//                });
                $product = $product->get();
//                dd(\DB::getQueryLog ());
//                dd($product->toArray());

                \DB::enableQueryLog();

                //+
                if (count($product->toArray())){
//                    $value->products = $product;
                    foreach ($product as $i=>$p){

                        if(!isset($variant[$p['product_id']])){
//                            dd($p['addons']);
                            $addons=Addons::whereRaw(\DB::raw("FIND_IN_SET(addons.id, '".$p['addons']."')"))->get()->toArray();
//                            print_r($addons);
//                            dd(\DB::getQueryLog ());
                            $variant[$p['product_id']]=['product_id'=>$p['product_id'],
                                'product_name'=>$p['product_name'],
                                'product_price'=>$p['product_price'],
                                'customizable'=>$p['customizable'],
                                'image'=>$p['image'],
                                'type'=>$p['type'],
                                'product_rating'=>$p['product_rating'],
                                'categoryName'=>$p['categoryName'],
                                'is_like'=>$p['is_like']
                            ];
                            if(count($addons))
                            $variant[$p['product_id']]['addons']=$addons;
                        }
                        if($p->variant_id!=''){
                            $variant[$p['product_id']]['options'][$p->variant_id]=['id'=>$p->variant_id,
                                'variant_name'=>$p->variant_name,
                                'variant_price'=>$p->variant_price];
                        }
                        if($p->addon_id!='')
                        $variant[$p['product_id']]['addons'][$p->addon_id]=['id'=>$p->addon_id,
                            'addon'=>$p->addon,
                            'price'=>$p->addon_price];
                    }
                    foreach ($variant as $i=>$v) {
                        if(isset($variant[$i]['options']))
                            $variant[$i]['options']=array_values($variant[$i]['options']);
                        if(isset($variant[$i]['addons']))
                            $variant[$i]['addons']=array_values($variant[$i]['addons']);
                    }
                    $variant=array_values($variant);

                    $catData[] =['menuName'=>$value->menuName,
                        'id'=>$value->id,
                        'products'=>$variant];
                }
            }
            return response()->json([
                'status' => true,
                'message' => 'Data Get Successfully',
                'response' => array('products'=>$catData,'coupons'=>$coupon)

            ], 200);
        } catch (Throwable $th) {
            return response()->json([
                'status' => false,
                'error' => $th->getMessage()
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
                    'food_type'=>'required|in:veg,non_veg,eggs'
                ]
            );
            if ($validateUser->fails()) {
                $error = $validateUser->errors();
                return response()->json([
                    'status' => false,
                    'error' => $validateUser->errors()->all()

                ], 401);
            }
            $category = VendorMenus::where(['vendor_id' => $request->vendor_id])->select('menuName', 'id')->get();
            $data = [];
            $dk = 0;
            foreach ($category as $key => $value) {
                $product = Product_master::where(['products.status' => '1', 'product_for' => '3']);
                $product = $product->join('categories', 'products.category', '=', 'categories.id');
                $product = $product->leftJoin('user_product_like',function($join){
                    $join->on('products.id', '=', 'user_product_like.product_id');
                    $join->where('user_product_like.user_id', '=',request()->user()->id );
                });
                $product = $product->where('menu_id', '=', $value->id);
                $product = $product->select('products.product_name', 'product_price', 'customizable', \DB::raw('CONCAT("' . asset('products') . '/", product_image) AS image'),'type','products.id as product_id','product_rating','categories.name as categoryName',\DB::raw('if(user_product_like.user_id is not null, true, false)  as is_like'));
                $product = $product->where('type', '=', $request->food_type);
                if($product->exists()){
                    $product = $product->get();
                    $data[$dk] = array('menuName'=>$value->menuName,'id' =>$value->id ,'products' => $product);

                    $dk++;
                }


            }

            return response()->json([
                'status' => true,
                'message' => 'Data Get Successfully',
                'response' => $data

            ], 200);
        } catch (Throwable $th) {
            return response()->json([
                'status' => false,
                'error' => $th->getMessage()
            ], 500);
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
                    'error' => $validateUser->errors()->all()

                ], 401);
            }
            //
            $category = VendorMenus::query()
                ->select('menuName', \DB::raw('count(*) as count'))
                ->join('products as c', 'vendor_menus.id', 'c.menu_id')
                ->where('vendor_menus.vendor_id', '=', $request->vendor_id)
                ->groupBy('menuName')
                ->get();
            //
            return response()->json([
                'status' => true,
                'message' => 'Data Get Successfully',
                'response' => $category

            ], 200);
        } catch (Throwable $th) {
            return response()->json([
                'status' => false,
                'error' => $th->getMessage()
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
                    'error' => $validateUser->errors()->all()

                ], 401);
            }
            //
            $product = Product_master::where('id', '=', $request->product_id)->select('addons', 'customizable')->first();

            if (@$product->customizable == 'true') {
                $options = unserialize($product->variants);
                if ($product->addons == null) {
                    $data = ['addons' => []];
                } else {
                    $addon = Addons::whereIn('id',explode(',',$product->addons))->select('id','addon','price')->get()->toArray();
                    $data = ['addons' => $addon];
                }

                $v = Variant::select('variant_name', 'variant_price','id')->where('product_id', $request->product_id)->get();
                // dd($v->toArray());
                if (isset($v))
                    $data['options'] = $v->toArray();

                // dd($product);
                return response()->json([
                    'status' => true,
                    'message' => 'Data Get Successfully',
                    'response' => $data

                ], 200);
            } else {
                return response()->json([
                    'status' => false,
                    'error' => 'Custmization not available'

                ], 401);
            }
        } catch (Throwable $th) {
            return response()->json([
                'status' => false,
                'error' => $th->getMessage()
            ], 500);
        }
    }

    public function getRestaurantSearchData(Request $request)
    {
        try {
            $validateUser = Validator::make(
                $request->all(),
                [
                    'keyword' => 'required',
                    'search_for' => 'required',
                    'offset' => 'required|numeric',
                ]
            );
            if ($validateUser->fails()) {
                $error = $validateUser->errors();
                return response()->json([
                    'status' => false,
                    'error' => $validateUser->errors()->all()

                ], 401);
            }
            //
            if ($request->search_for == 'restaurant') {
                $data = Vendors::where(['status' => '1', 'vendor_type' => 'restaurant', 'is_all_setting_done' => '1'])->select('name', \DB::raw('CONCAT("' . asset('vendors') . '/", image) AS image'), 'vendor_ratings', 'review_count')->where('name', 'like', '%' . $request->keyword . '%')->skip($request->offset)->take(10)->get();
            } elseif ($request->search_for == 'dishes') {
                $data = Product_master::where(['products.status' => '1', 'product_for' => '3'])->join('vendors', 'products.userId', '=', 'vendors.id')->select('products.product_name', \DB::raw('CONCAT("' . asset('products') . '/", product_image) AS image', 'vendors.name as restaurantName'), 'product_price', 'type')->where('vendors.name', 'like', '%' . $request->keyword . '%')->skip($request->offset)->take(10)->get();
            } else {
                $data = [];
            }

            return response()->json([
                'status' => true,
                'message' => 'Data Get Successfully',
                'response' => $data

            ], 200);
        } catch (Throwable $th) {
            return response()->json([
                'status' => false,
                'error' => $th->getMessage()
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
                    'error' => $validateUser->errors()->all()

                ], 401);
            }
            $select = "( 3959 * acos( cos( radians($request->lat) ) * cos( radians( vendors.lat ) ) * cos( radians( vendors.long ) - radians($request->lng) ) + sin( radians($request->lat) ) * sin( radians( vendors.lat ) ) ) ) ";
            $vendors = Vendors::where(['status' => '1', 'vendor_type' => 'chef', 'is_all_setting_done' => '1']);
            $vendors = $vendors->select('vendors.id as chef_id','name', 'vendor_ratings', 'review_count', \DB::raw('CONCAT("' . asset('vendors') . '/", image) AS image'), \DB::raw("DATE_FORMAT(FROM_DAYS(DATEDIFF(now(),dob)), '%Y')+0 AS Age"), 'experience',\DB::raw("0 as order_served"),\DB::raw('if(user_vendor_like.user_id is not null, true, false)  as is_like'));
            $vendors = $vendors->selectRaw("ROUND({$select},1) AS distance");
            $vendors = $vendors->leftJoin('user_vendor_like',function($join){
                $join->on('vendors.id', '=', 'user_vendor_like.vendor_id');
                $join->where('user_vendor_like.user_id', '=',request()->user()->id );
            });
            $vendors = $vendors->addSelect(DB::raw('(SELECT name FROM cuisines WHERE  cuisines.id IN (vendors.speciality) ) AS food_specility'));
            $vendors = $vendors->orderBy('vendors.id', 'desc')->get();
            $products = Product_master::where(['products.status' => '1', 'product_for' => '2'])->join('vendors', 'products.userId', '=', 'vendors.id')->select('products.product_name', 'product_price', 'customizable', \DB::raw('CONCAT("' . asset('products') . '/", product_image) AS image', 'vendors.name as restaurantName'))->orderBy('products.id', 'desc')->get();
            return response()->json([
                'status' => true,
                'message' => 'Data Get Successfully',
                'response' => ['vendors' => $vendors, 'products' => $products]

            ], 200);
        } catch (Throwable $th) {
            return response()->json([
                'status' => false,
                'error' => $th->getMessage()
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
                    'lat' => 'required|numeric',
                    'lng' => 'required|numeric',
                ]
            );
            if ($validateUser->fails()) {
                $error = $validateUser->errors();
                return response()->json([
                    'status' => false,
                    'error' => $validateUser->errors()->all()

                ], 401);
            }
            //$data = \App\Models\Product_master::distinct('userId')->select('userId','vendors.name','')->join('vendors','products.userId','=','vendors.id')->where(['products.status'=>'1','product_for'=>'3','category' => $request->category_id])->get();
            $select = "( 3959 * acos( cos( radians($request->lat) ) * cos( radians( vendors.lat ) ) * cos( radians( vendors.long ) - radians($request->lng) ) + sin( radians($request->lat) ) * sin( radians( vendors.lat ) ) ) ) ";
            $data = Vendors::select('name', \DB::raw('CONCAT("' . asset('vendors') . '/", image) AS image'), \DB::raw("DATE_FORMAT(FROM_DAYS(DATEDIFF(now(),dob)), '%Y')+0 AS Age"), 'vendor_ratings', 'speciality', 'deal_categories', 'vendors.id as chef_id', 'experience', 'fssai_lic_no',\DB::raw("0 as order_served"),"vendor_food_type","review_count",\DB::raw('if(user_vendor_like.user_id is not null, true, false)  as is_like'));
            $data = $data->selectRaw("ROUND({$select},1) AS distance");
            $data = $data->addSelect(DB::raw('(SELECT name FROM cuisines WHERE  cuisines.id IN (vendors.speciality) ) AS food_specility'));
            $data = $data->where(['vendors.status' => '1', 'vendor_type' => 'chef', 'is_all_setting_done' => '1'])->whereRaw('FIND_IN_SET("' . $request->category_id . '",deal_categories)');
            $data = $data->leftJoin('user_vendor_like',function($join){
                $join->on('vendors.id', '=', 'user_vendor_like.vendor_id');
                $join->where('user_vendor_like.user_id', '=',request()->user()->id );
            });
            $data = $data->get();
            date_default_timezone_set('Asia/Kolkata');
            foreach ($data as $key => $value) {
                $category = Catogory_master::whereIn('id', explode(',', $value->deal_categories))->pluck('name');
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
                $data[$key]->is_like = true;
            }
            return response()->json([
                'status' => true,
                'message' => 'Data Get Successfully',
                'response' => $data

            ], 200);
        } catch (Throwable $th) {
            return response()->json([
                'status' => false,
                'error' => $th->getMessage()
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
                    'error' => $validateUser->errors()->all()

                ], 401);
            }
            $category = Product_master::where(['userId' => $request->vendor_id])
            ->select('product_name', 'products.id as product_id', 'type', 'category', 'cuisines', 'product_price', 'customizable',\DB::raw('CONCAT("' . asset('products') . '/", product_image) AS image'),'cuisines.name as cuisines_name',\DB::raw('if(user_product_like.user_id is not null, true, false)  as is_like'),'product_rating')
            ->join('cuisines','products.cuisines','=','cuisines.id')
            ->leftJoin('user_product_like',function($join){
                $join->on('products.id', '=', 'user_product_like.product_id');
                $join->where('user_product_like.user_id', '=',request()->user()->id );
            })
            ->get();

            return response()->json([
                'status' => true,
                'message' => 'Data Get Successfully',
                'response' => $category

            ], 200);
        } catch (Throwable $th) {
            return response()->json([
                'status' => false,
                'error' => $th->getMessage()
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
                    'error' => $validateUser->errors()->all()

                ], 401);
            }

            $vendors = Vendors::where(['id'=>$request->vendor_id,'vendor_type'=>'chef']);

            $vendors = $vendors->select('name', \DB::raw('CONCAT("' . asset('vendors') . '/", image) AS image'), \DB::raw("DATE_FORMAT(FROM_DAYS(DATEDIFF(now(),dob)), '%Y')+0 AS Age"), 'vendor_ratings', 'speciality', 'deal_categories', 'id', 'experience', 'fssai_lic_no','bio')->first();

            $cuisines = Cuisines::whereIn('id', explode(',', $vendors->speciality))->pluck('name');
            $vendors->speciality = $cuisines;
            $videos = Chef_video::where('userId', '=', $request->vendor_id)->get();
            return response()->json([
                'status' => true,
                'message' => 'Data Get Successfully',
                'response' => ['profile' => $vendors, 'videos' => $videos]

            ], 200);
        } catch (Throwable $th) {
            return response()->json([
                'status' => false,
                'error' => $th->getMessage()
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
                'user_id' => 'required|numeric',
                'vendor_id' => 'required|numeric'
            ]);
            UserVendorLike::updateOrCreate([
                'user_id' =>$request->user_id,
                'vendor_id' =>$request->vendor_id
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Liked Successfully',
                'response' => true

            ], 200);


        } catch (Throwable $th) {
            return response()->json([
                'status' => false,
                'error' => $th->getMessage()
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
                'user_id' => 'required|numeric',
                'product_id' => 'required|numeric'
            ]);
            if ($validateUser->fails()) {
                $error = $validateUser->errors();
                return response()->json(['status' => false, 'error' => $validateUser->errors()->all()], 401);
            }
            UserProductLike::updateOrCreate([
                'user_id' =>$request->user_id,
                'product_id' =>$request->product_id
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Liked Successfully',
                'response' => true

            ], 200);


        } catch (Throwable $th) {
            return response()->json([
                'status' => false,
                'error' => $th->getMessage()
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
                    'user_id' => 'required|numeric',
                    'vendor_id' => 'required|numeric',
                    'user_id' => 'required|numeric',
                    'customer_name' => 'required|string',
                    'delivery_address' => 'required|string',
                    'city' => 'required|string',
                    'pincode' => 'required|string',
                    'lat' => 'required|string',
                    'long' => 'required|string',

                    'total_amount' => 'required|numeric',
                    'gross_amount' => 'required|numeric',
                    'net_amount' => 'required|numeric',
                    'discount_amount' => 'required|numeric',
                    'coupon_id' => 'nullable|numeric',
                    'payment_type' => 'nullable|string',
                    'payment_status' => 'nullable|string',
                    'transaction_id' => 'nullable|string',
                    'payment_string' => 'nullable|string',

                    'products.*.product_id' => 'required|numeric',
                    'products.*.product_qty' => 'required|numeric',
                    'products.*.product_name' => 'required|string',

                    'products.*.variants.*.variant_id' => 'numeric|nullable',
                    'products.*.variants.*.variant_qty' => 'numeric|nullable',
                    'products.*.variants.*.variant_price' => 'numeric|nullable',
                    'products.*.variants.*.variant_name' => 'string|nullable',

                    'products.*.addons.*.addon_id' => 'numeric|nullable',
                    'products.*.addons.*.addon_qty' => 'numeric|nullable',
                    'products.*.addons.*.addon_price' => 'numeric|nullable',
                    'products.*.addons.*.addon_name' => 'string|nullable',
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
                    return response()->json(['status' => False, 'error' => "Vendor not available" ], 401);
                $data = $request->all();
                if (is_array($request->payment_string))
                    $data['payment_string'] = serialize($request->payment_string);

                $Order = new Order($request->all());
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

                DB::commit();

                event(new OrderCreateEvent($order_id, $request->user_id, $request->vendor_id));
                return response()->json(['status' => true, 'message' => 'Data Get Successfully', 'response' => ["order_id" => $order_id]], 200);
            } catch (PDOException $e) {
                // Woopsy
                DB::rollBack();
                return response()->json(['status' => false, 'error' => $e->getMessage()], 500);
            }
        } catch (Throwable $th) {
            return response()->json(['status' => False,
                'error' => $th->getMessage(),
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
                    'offset' => 'required|numeric'
                ],
                [
                    "order_for.in" =>'Order For Value Should be in restaurant or chef or dineout',
                    "order_for.required" =>'Order For is required'
                ]

            );
            if ($validateUser->fails()) {
                $error = $validateUser->errors();
                return response()->json(['status' => false, 'error' => $validateUser->errors()->all()], 401);
            }
            if($request->order_for == 'restaurant'){
                $order = Order::where('user_id','=',request()->user()->id);
                $order = $order->select(\DB::raw('CONCAT("' . asset('vendors') . '/", image) AS image'),'orders.id as order_id','vendors.name as vendor_name','order_status','net_amount','payment_type',\DB::raw("DATE_FORMAT(orders.created_at, '%d %b %Y at %H:%i %p') as order_date"));
                $order = $order->join('vendors','orders.vendor_id','=','vendors.id');
                $order = $order->where('vendors.vendor_type','=','restaurant');
                $order = $order->orderBy('orders.id','desc');
                $order = $order->skip($request->offset)->take(10);
                $order = $order->get();

                foreach ($order as $key => $value) {
                    $products = OrderProduct::where('order_id','=',$value->order_id)->join('products','order_products.product_id','products.id')->select('product_id','order_products.product_name','order_products.product_price','product_qty')->get();
                    $order[$key]->products = $products;
                }

                return response()->json([
                    'status' => true,
                    'message' => 'data get Successfully',
                    'response' => $order

                ], 200);



            }
            if($request->order_for == 'chef'){

            }
            if($request->order_for == 'dineout'){

            }

        } catch (Throwable $th) {
            return response()->json(['status' => False,
                'error' => $th->getMessage(),
            ], 500);
        }
    }

    public function deleteLikeProduct(Request $request)
    {
        try {

            $validateUser = Validator::make($request->all(), [
                'user_id' => 'required|numeric',
                'product_id' => 'required|numeric'
            ]);
            if ($validateUser->fails()) {
                $error = $validateUser->errors();
                return response()->json(['status' => false, 'error' => $validateUser->errors()->all()], 401);
            }
            UserProductLike::where([
                'user_id' =>$request->user_id,
                'product_id' =>$request->product_id
            ])->delete();

            return response()->json([
                'status' => true,
                'message' => 'Dislike Successfully',
                'response' => true

            ], 200);


        } catch (Throwable $th) {
            return response()->json([
                'status' => false,
                'error' => $th->getMessage()
            ], 500);
        }
    }
    public function deleteLikeVendor(Request $request)
    {
        try {

            $validateUser = Validator::make($request->all(), [
                'user_id' => 'required|numeric',
                'vendor_id' => 'required|numeric'
            ]);
            if ($validateUser->fails()) {
                $error = $validateUser->errors();
                return response()->json(['status' => false, 'error' => $validateUser->errors()->all()], 401);
            }
            UserVendorLike::where([
                'user_id' =>$request->user_id,
                'vendor_id' =>$request->vendor_id
            ])->delete();

            return response()->json([
                'status' => true,
                'message' => 'Dislike Successfully',
                'response' => true

            ], 200);


        } catch (Throwable $th) {
            return response()->json([
                'status' => false,
                'error' => $th->getMessage()
            ], 500);
        }
    }

    public function getUserInfo(Request $request)
    {
        try {

            $user = User::find(request()->user()->id)->select('id','name','email','alternative_number')->first();

            return response()->json([
                'status' => true,
                'message' => 'Data get Successfully',
                'response' =>$user

            ], 200);


        } catch (Throwable $th) {
            return response()->json([
                'status' => false,
                'error' => $th->getMessage()
            ], 500);
        }
    }
    public function updateUserInfo(Request $request)
    {
        try {
            $validateUser = Validator::make($request->all(), [
                'name' => 'required',
                'email' => 'required',
                'alternative_number' => 'required',
            ]);
            if ($validateUser->fails()) {
                $error = $validateUser->errors();
                return response()->json(['status' => false, 'error' => $validateUser->errors()->all()], 401);
            }
            //$user = User::find(request()->user()->id);

            $update = User::where('id','=',request()->user()->id)->update(['name'=>$request->name,'email' =>$request->email,'alternative_number'=>$request->alternative_number]);

            return response()->json([
                'status' => true,
                'message' => 'User Updated Successfully'

            ], 200);


        } catch (Throwable $th) {
            return response()->json([
                'status' => false,
                'error' => $th->getMessage()
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
                    'error' => $validateUser->errors()->all()

                ], 401);
            }
            $vendors = UserVendorLike::where('vendor_id','=',request()->user()->id);
            $select = "( 3959 * acos( cos( radians($request->lat) ) * cos( radians( vendors.lat ) ) * cos( radians( vendors.long ) - radians($request->lng) ) + sin( radians($request->lat) ) * sin( radians( vendors.lat ) ) ) ) ";
            $userid = request()->user()->id;
            $vendors = $vendors->join('vendors','user_vendor_like.vendor_id','=','vendors.id');
            $vendors = $vendors->where(['vendors.status' => '1', 'vendor_type' => 'restaurant', 'is_all_setting_done' => '1']);
            $vendors = $vendors->select('name', \DB::raw('CONCAT("' . asset('vendors') . '/", image) AS image'), 'vendor_ratings','vendors.id','lat','long','deal_categories' );
            $vendors = $vendors->selectRaw("ROUND({$select},1) AS distance");
            $vendors = $vendors->orderBy('vendors.id', 'desc')->get();

            return response()->json([
                'status' => true,
                'message' => 'data get Successfully',
                'response' => $vendors

            ], 200);


        } catch (Throwable $th) {
            return response()->json([
                'status' => false,
                'error' => $th->getMessage()
            ], 500);
        }
    }

}
