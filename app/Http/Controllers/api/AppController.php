<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Addons;
use App\Models\Cart;
use App\Models\CartAddon;
use App\Models\CartProduct;
use App\Models\CartProductVariant;
use Illuminate\Http\Request;
use Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AppController extends Controller
{

    public function getProductDetail(Request $request)
    {
        try {
            $validateUser = Validator::make($request->all(), 
                [
                    'product_id' => 'required|numeric'
                ]);
                if($validateUser->fails()){
                    $error = $validateUser->errors();
                    return response()->json([
                        'status' => false,
                        'error'=>$validateUser->errors()->all()
                        
                    ], 401);
                }
            $product = \App\Models\Product_master::where(['products.id'=>$request->product_id]);
            $product = $product->join('cuisines','products.cuisines','=','cuisines.id');
            $product = $product->select('products.product_name','product_price','customizable',\DB::raw('CONCAT("'.asset('products').'/", product_image) AS image'),'cuisines.name as cuisinesName','dis as description')->first();
            

            return response()->json([
                'status' => true,
                'message'=>'Data Get Successfully',
                'response'=>$product

            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'error' => $th->getMessage()
            ], 500);
        }
    }
    //restaurant page
        public function restaurantHomePage()
        {
            try {

                $vendors = \App\Models\Vendors::where(['status'=>'1','vendor_type'=>'restaurant','is_all_setting_done' =>'1'])->select('name',\DB::raw('CONCAT("'.asset('vendors').'/", image) AS image'),'vendor_ratings',\DB::raw('CONCAT("'.asset('vendor-banner').'/", banner_image) AS banner'))->orderBy('id','desc')->get();
                $products = \App\Models\Product_master::where(['products.status'=>'1','product_for'=>'3'])->join('vendors','products.userId','=','vendors.id')->select('products.product_name','product_price','customizable',\DB::raw('CONCAT("'.asset('products').'/", product_image) AS image','vendors.name as restaurantName'))->orderBy('products.id','desc')->get();

                return response()->json([
                    'status' => true,
                    'message'=>'Data Get Successfully',
                    'response'=>['vendors'=>$vendors,'products' => $products]
    
                ], 200);
    
            } catch (\Throwable $th) {
                return response()->json([
                    'status' => false,
                    'error' => $th->getMessage()
                ], 500);
            }
        }
        
        public function getRestaurantByCategory(Request $request)
        {
            try {
                $validateUser = Validator::make($request->all(), 
                [
                    'category_id' => 'required|numeric'
                ]);
                if($validateUser->fails()){
                    $error = $validateUser->errors();
                    return response()->json([
                        'status' => false,
                        'error'=>$validateUser->errors()->all()
                        
                    ], 401);
                }
                //$data = \App\Models\Product_master::distinct('userId')->select('userId','vendors.name','')->join('vendors','products.userId','=','vendors.id')->where(['products.status'=>'1','product_for'=>'3','category' => $request->category_id])->get();
                $data = \App\Models\Vendors::select('name',\DB::raw('CONCAT("'.asset('vendors').'/", image) AS image'),'banner_image','vendor_ratings','vendor_food_type','deal_categories','id','fssai_lic_no');
                $data = $data->where(['vendors.status'=>'1','vendor_type'=>'restaurant','is_all_setting_done' =>'1'])->whereRaw('FIND_IN_SET("'.$request->category_id.'",deal_categories)');
                
                $data = $data->get();
                date_default_timezone_set('Asia/Kolkata');
                $baseurl =  \URL::to('vendor-banner/').'/';
                foreach ($data as $key => $value) {
                    
                    $banners =  json_decode($value->banner_image);
                     $urlbanners = array_map(function($banner) {
                        return \URL::to('vendor-banner/').'/'.$banner;
                    }, $banners);
                    
                    $category =  \App\Models\Catogory_master::whereIn('id',explode(',',$value->deal_categories))->pluck('name');
                    $timeSchedule =  \App\Models\VendorOrderTime::where(['vendor_id'=>$value->id,'day_no'=>Carbon::now()->dayOfWeek])->first();
                    if ($timeSchedule->available) {
                        if (strtotime(date('H:i:s')) >= strtotime($timeSchedule->start_time) && strtotime(date('H:i:s')) <= strtotime($timeSchedule->end_time)){
                            $data[$key]->isClosed = false;
                        }else{
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
                    'message'=>'Data Get Successfully',
                    'response'=>$data
    
                ], 200);
            } catch (\Throwable $th) {
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
            $category = \App\Models\VendorMenus::where(['vendor_id' => $request->vendor_id])->select('menuName', 'id')->get();
            foreach ($category as  $key => $value) {
                $product = \App\Models\Product_master::where(['products.status' => '1', 'product_for' => '3']);
                $product = $product->join('categories', 'products.category', '=', 'categories.id');
                $product = $product->where('menu_id', '=', $value->id);
                $product = $product->select('products.product_name', 'product_price', 'customizable', \DB::raw('CONCAT("' . asset('products') . '/", product_image) AS image'));
                $product = $product->get();
                $category[$key]->products = $product;
            }
            return response()->json([
                'status' => true,
                'message' => 'Data Get Successfully',
                'response' => $category

            ], 200);
        } catch (\Throwable $th) {
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
            $category = \App\Models\VendorMenus::query()
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
        } catch (\Throwable $th) {
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
            $product =  \App\Models\Product_master::where('id', '=', $request->product_id)->select('variants', 'addons', 'customizable')->first();
            if ($product->customizable == 'true') {
                $options = unserialize($product->variants);
                if ($product->addons == null) {
                    $data = ['options' => $options, 'addons' => $product->addons];
                } else {
                    $data = ['options' => $options, 'addons' => unserialize($product->addons)];
                }
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
        } catch (\Throwable $th) {
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
                $data =  \App\Models\Vendors::where(['status' => '1', 'vendor_type' => 'restaurant', 'is_all_setting_done' => '1'])->select('name', \DB::raw('CONCAT("' . asset('vendors') . '/", image) AS image'), 'vendor_ratings', 'review_count')->where('name', 'like', '%' . $request->keyword . '%')->skip($request->offset)->take(10)->get();
            } elseif ($request->search_for == 'dishes') {
                $data =  \App\Models\Product_master::where(['products.status' => '1', 'product_for' => '3'])->join('vendors', 'products.userId', '=', 'vendors.id')->select('products.product_name', \DB::raw('CONCAT("' . asset('products') . '/", product_image) AS image', 'vendors.name as restaurantName'), 'product_price', 'type')->where('vendors.name', 'like', '%' . $request->keyword . '%')->skip($request->offset)->take(10)->get();
            } else {
                $data = [];
            }

            return response()->json([
                'status' => true,
                'message' => 'Data Get Successfully',
                'response' => $data

            ], 200);
        } catch (\Throwable $th) {
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
            $vendors = \App\Models\Vendors::where(['status' => '1', 'vendor_type' => 'chef', 'is_all_setting_done' => '1'])->select('name', 'vendor_ratings', 'review_count', \DB::raw('CONCAT("' . asset('vendors') . '/", image) AS image', 'rating'), \DB::raw("DATE_FORMAT(FROM_DAYS(DATEDIFF(now(),dob)), '%Y')+0 AS Age"), 'experience')->orderBy('id', 'desc')->get();
            $products = \App\Models\Product_master::where(['products.status' => '1', 'product_for' => '2'])->join('vendors', 'products.userId', '=', 'vendors.id')->select('products.product_name', 'product_price', 'customizable', \DB::raw('CONCAT("' . asset('products') . '/", product_image) AS image', 'vendors.name as restaurantName'))->orderBy('products.id', 'desc')->get();
            return response()->json([
                'status' => true,
                'message' => 'Data Get Successfully',
                'response' => ['vendors' => $vendors, 'products' => $products]

            ], 200);
        } catch (\Throwable $th) {
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
                ]);
                if($validateUser->fails()){
                    $error = $validateUser->errors();
                    return response()->json([
                        'status' => false,
                        'error'=>$validateUser->errors()->all()
                        
                    ], 401);
                }
                //$data = \App\Models\Product_master::distinct('userId')->select('userId','vendors.name','')->join('vendors','products.userId','=','vendors.id')->where(['products.status'=>'1','product_for'=>'3','category' => $request->category_id])->get();
                $data = \App\Models\Vendors::select('name',\DB::raw('CONCAT("'.asset('vendors').'/", image) AS image'),\DB::raw("DATE_FORMAT(FROM_DAYS(DATEDIFF(now(),dob)), '%Y')+0 AS Age"),'vendor_ratings','speciality','deal_categories','id','experience','fssai_lic_no');
                $data = $data->where(['vendors.status'=>'1','vendor_type'=>'chef','is_all_setting_done' =>'1'])->whereRaw('FIND_IN_SET("'.$request->category_id.'",deal_categories)');
                
                $data = $data->get();
                date_default_timezone_set('Asia/Kolkata');
                foreach ($data as $key => $value) {
                    $category =  \App\Models\Catogory_master::whereIn('id',explode(',',$value->deal_categories))->pluck('name');
                    $timeSchedule =  \App\Models\VendorOrderTime::where(['vendor_id'=>$value->id,'day_no'=>Carbon::now()->dayOfWeek])->first();
                    
                    if ($timeSchedule->available) {
                        if (strtotime(date('H:i:s')) >= strtotime($timeSchedule->start_time) && strtotime(date('H:i:s')) <= strtotime($timeSchedule->end_time)){
                            $data[$key]->isClosed = false;
                        }else{
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
                    'message'=>'Data Get Successfully',
                    'response'=>$data
    
                ], 200);
            } catch (\Throwable $th) {
                return response()->json([
                    'status' => false,
                    'error' => $th->getMessage()
                ], 500);
            }

            
        }
        public function getChefDetailPage(Request $request)
        {
            try {
                $validateUser = Validator::make($request->all(), 
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
            $category = \App\Models\Product_master::where(['userId' => $request->vendor_id])->select('product_name', 'id', 'product_image', 'type', 'category', 'cuisines', 'product_price', 'customizable')->get();

            return response()->json([
                'status' => true,
                'message' => 'Data Get Successfully',
                'response' => $category

            ], 200);
        } catch (\Throwable $th) {
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

            $vendors = \App\Models\Vendors::where('id', '=', $request->vendor_id)->select('name', \DB::raw('CONCAT("' . asset('vendors') . '/", image) AS image'), \DB::raw("DATE_FORMAT(FROM_DAYS(DATEDIFF(now(),dob)), '%Y')+0 AS Age"), 'vendor_ratings', 'speciality', 'deal_categories', 'id', 'experience', 'fssai_lic_no')->first();
            $vendors->bio = 'I am here to entice your taste-buds! #enticeyourtastebuds  Boring recipes can make you sad, so always try to make  some interesting cuisine.  We will feel ill if we spend too much time out of the kitchen.  Chefs know that cooking is not their job but the calling  of life. A chef has the common drive of spreading happiness';
            $videos = \App\Models\Chef_video::where('userId', '=', $request->vendor_id)->get();
            return response()->json([
                'status' => true,
                'message' => 'Data Get Successfully',
                'response' => ['profile' => $vendors, 'videos' => $videos]

            ], 200);
        } catch (\Throwable $th) {
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
                    'products.*.variants.*.id' => 'numeric|nullable',
                    'products.*.variants.*.variant_qty' => 'string|nullable',
                    'addons.*.id' => 'numeric|nullable',
                    'addons.*.addon_qty' => "numeric|nullable"
                ]
            );
            if ($validateUser->fails()) {
                $error = $validateUser->errors();
                return response()->json([
                    'status' => false,
                    'error' => $validateUser->errors()->all()

                ], 401);
            }
            global $cart_id;
            try {
                DB::beginTransaction();
                // database queries here

                $cart_obj = new Cart($request->all());
                $cart_obj->user_id = $request->user_id;
                $cart_obj->vendor_id = $request->vendor_id;
                $cart_obj->saveOrFail();
                $cart_id=$cart_obj->id;
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
                }


                if (isset($request->addons))
                    foreach ($request->addons as $k => $a) {
                        $addons[] = new CartAddon($a);
                    }
                $cart_obj->addons()->saveMany($addons);




                DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Data Get Successfully',
                'response' => ["cart_id"=>$cart_id]

            ], 200);
            } catch (\PDOException $e) {
                // Woopsy
                DB::rollBack();
                return response()->json([
                    'status' => false,
                    'error' => $e->getMessage()
                ], 500);
            }

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'error' => $th->getMessage()
            ], 500);
        }
    }
}
