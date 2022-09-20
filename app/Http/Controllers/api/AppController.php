<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartProduct;
use App\Models\CartProductAddon;
use App\Models\CartProductVariant;
use App\Models\Catogory_master;
use App\Models\Chef_video;
use App\Models\Product_master;
use App\Models\User;
use App\Models\Variant;
use App\Models\VendorMenus;
use App\Models\VendorOrderTime;
use App\Models\Vendors;
use App\Models\UserProductLike;
use App\Models\UserVendorLike;

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
            $product = $product->select('products.product_name', 'product_price', 'customizable', \DB::raw('CONCAT("' . asset('products') . '/", product_image) AS image'), 'cuisines.name as cuisinesName', 'dis as description')->first();


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

    //restaurant page
    public function restaurantHomePage(Request $request)
    {
        try {
            $userid = request()->user()->id;
            $vendors = Vendors::where(['status' => '1', 'vendor_type' => 'restaurant', 'is_all_setting_done' => '1'])->select('name', \DB::raw('CONCAT("' . asset('vendors') . '/", image) AS image'), 'vendor_ratings','id' )->orderBy('id', 'desc')->get();
            $products = Product_master::where(['products.status' => '1', 'product_for' => '3'])->join('vendors', 'products.userId', '=', 'vendors.id')->select('products.product_name', 'product_price', 'customizable', \DB::raw('CONCAT("' . asset('products') . '/", product_image) AS image'),'vendors.name as restaurantName','products.id')->orderBy('products.id', 'desc')->get();
            foreach ($vendors as $key => $value) {
                if(UserVendorLike::where(['user_id'=>$userid,'vendor_id' =>$value['id']])->exists   ()){
                    $vendors[$key]['is_like'] = true;
                }else{
                    $vendors[$key]['is_like'] = false;
                }
            }
            foreach ($products as $key => $value) {
                if(UserProductLike::where(['user_id'=>$userid,'product_id' =>$value['id']])->exists()){
                    $products[$key]['is_like'] = true;
                }else{
                    $products[$key]['is_like'] = false;
                }
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
                    'category_id' => 'required|numeric'
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
            $data = Vendors::select('name', \DB::raw('CONCAT("' . asset('vendors') . '/", image) AS image'), 'banner_image', 'vendor_ratings', 'vendor_food_type', 'deal_categories', 'id', 'fssai_lic_no','table_service');
            $data = $data->where(['vendors.status' => '1', 'vendor_type' => 'restaurant', 'is_all_setting_done' => '1'])->whereRaw('FIND_IN_SET("' . $request->category_id . '",deal_categories)');

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
                    'cuisines_id' => 'required|numeric'
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
            $data = Vendors::select('name', \DB::raw('CONCAT("' . asset('vendors') . '/", image) AS image'), 'banner_image', 'vendor_ratings', 'vendor_food_type', 'deal_categories', 'id', 'fssai_lic_no','table_service');
            $data = $data->where(['vendors.status' => '1', 'vendor_type' => 'restaurant', 'is_all_setting_done' => '1'])->whereRaw('FIND_IN_SET("' . $request->cuisines_id . '",deal_cuisines)');

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
            foreach ($category as $key => $value) {
                $product = Product_master::where(['products.status' => '1', 'product_for' => '3']);
                $product = $product->join('categories', 'products.category', '=', 'categories.id');
                $product = $product->where('menu_id', '=', $value->id);
                $product = $product->select('products.product_name', 'product_price', 'customizable', \DB::raw('CONCAT("' . asset('products') . '/", product_image) AS image'),'type');
                $product = $product->get();
                $category[$key]->products = $product;
            }
            
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
                $product = $product->where('menu_id', '=', $value->id);
                $product = $product->select('products.product_name', 'product_price', 'customizable', \DB::raw('CONCAT("' . asset('products') . '/", product_image) AS image'),'type');
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
                    $data = ['addons' => $product->addons];
                } else {
                    $data = [ 'addons' => @unserialize($product->addons)];
                }

                $v = Variant::select('variant_name','variant_price')->where('product_id', $request->product_id)->get();
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
    public function chefHomePage()
    {
        try {
            $vendors = Vendors::where(['status' => '1', 'vendor_type' => 'chef', 'is_all_setting_done' => '1'])->select('name', 'vendor_ratings', 'review_count', \DB::raw('CONCAT("' . asset('vendors') . '/", image) AS image', 'rating'), \DB::raw("DATE_FORMAT(FROM_DAYS(DATEDIFF(now(),dob)), '%Y')+0 AS Age"), 'experience')->orderBy('id', 'desc')->get();
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
                    'category_id' => 'required|numeric'
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
            $data = Vendors::select('name', \DB::raw('CONCAT("' . asset('vendors') . '/", image) AS image'), \DB::raw("DATE_FORMAT(FROM_DAYS(DATEDIFF(now(),dob)), '%Y')+0 AS Age"), 'vendor_ratings', 'speciality', 'deal_categories', 'id', 'experience', 'fssai_lic_no');
            $data = $data->where(['vendors.status' => '1', 'vendor_type' => 'chef', 'is_all_setting_done' => '1'])->whereRaw('FIND_IN_SET("' . $request->category_id . '",deal_categories)');

            $data = $data->get();
            date_default_timezone_set('Asia/Kolkata');
            foreach ($data as $key => $value) {
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
            $category = Product_master::where(['userId' => $request->vendor_id])->select('product_name', 'id', 'product_image', 'type', 'category', 'cuisines', 'product_price', 'customizable')->get();

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

            $vendors = Vendors::where('id', '=', $request->vendor_id)->select('name', \DB::raw('CONCAT("' . asset('vendors') . '/", image) AS image'), \DB::raw("DATE_FORMAT(FROM_DAYS(DATEDIFF(now(),dob)), '%Y')+0 AS Age"), 'vendor_ratings', 'speciality', 'deal_categories', 'id', 'experience', 'fssai_lic_no')->first();
            $vendors->bio = 'I am here to entice your taste-buds! #enticeyourtastebuds  Boring recipes can make you sad, so always try to make  some interesting cuisine.  We will feel ill if we spend too much time out of the kitchen.  Chefs know that cooking is not their job but the calling  of life. A chef has the common drive of spreading happiness';
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
        //        dd($request->all());
        try {
            $validateUser = Validator::make($request->all(), [
                'user_id' => 'required|numeric',
                'cart_id' => 'required|numeric'
            ]);
            if ($validateUser->fails()) {
                $error = $validateUser->errors();
                return response()->json(['status' => false, 'error' => $validateUser->errors()->all()], 401);
            }

            \DB::enableQueryLog();
            $cart_id = $request->cart_id;

            $e = Cart::where('id', $cart_id)->exists();
            if (!$e)
                return response()->json(['status' => false, 'error' => 'Cart does not exists.'], 401);

            $wallet_amount = 0;
            $u = User::select('wallet_amount')->find($request->user_id);
            if (isset($u->wallet_amount))
                $wallet_amount = $u->wallet_amount;


            $pro = \App\Models\Product_master::where('status', 1)
                ->whereIn(
                    "products.id",
                    function ($query) use ($cart_id) {
                        $query->select('product_id')->from('cart_products')->where('cart_id', $cart_id);
                    }
                )
                ->with(['product_variants', 'cuisines'])->get();

            if ($pro != null)
                $pro = $pro->toArray();

            //SELECT * FROM `cart_product_variants`
            //LEFT JOIN cart_products on cart_products.id=cart_product_variants.cart_product_id
            //where cart_id=7
            $variants = \App\Models\CartProductVariant::select('*')
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
                    $pro[$k]['addons'] = @\App\Models\Addons::select(DB::raw('distinct addons.id,addon_id, addon, price, addon_qty'))
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

    public function add_to_like_vendor(Request $request)
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
    //
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
}
