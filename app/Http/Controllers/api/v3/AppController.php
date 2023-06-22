<?php

namespace App\Http\Controllers\api\v3;

use App\Events\OrderCreateEvent;
use App\Http\Controllers\Controller;
use App\Models\Addons;
use App\Models\Cart;
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
use App\Models\User;
use App\Models\UserProductLike;
use App\Models\UserVendorLike;
use App\Models\Variant;
use App\Models\VendorMenus;
use App\Models\VendorOrderTime;
use App\Models\Vendors;
use App\Models\RiderAssignOrders;
use App\Models\PendingPaymentOrders;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDOException;
use Throwable;
use URL;
use Validator;
use App\Notifications\SendPushNotification;
class AppController extends Controller
{
    

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
            $category = VendorMenus::select('menuName', 'vendor_menus.id')->where('vendor_menus.vendor_id', '=', $request->vendor_id)->where('status', '=', "1")->orderBy('vendor_menus.position', 'ASC')->get();
            $date    = today()->format('Y-m-d');
            $coupon  = Coupon::where('vendor_id', '=', $request->vendor_id)->where('status', '=', 1)->where('from', '<=', $date)->where('to', '>=', $date)->select('*')->get();
            $catData = [];
            foreach ($category as $key => $value) {
                $variant = get_product_with_variant_and_addons_v3(['product_for' => '3', 'menu_id' => $value->id], request()->user()->id, '', '', false);
                if (count($variant)) {
                    $catData[] = [
                        'menuName' => $value->menuName,
                        'menu_id'  => $value->id,
                        'products' => $variant
                    ];
                }
            }
            $ProfileVisitUsers = new \App\Models\ProfileVisitUsers;
            $ProfileVisitUsers->vendor_id = $request->vendor_id;
            $ProfileVisitUsers->user_id = request()->user()->id;
            $ProfileVisitUsers->save();
            $vendorsOnline = \App\Models\Vendors::where('id','=',$request->vendor_id)->select('is_online')->first();
            return response()->json([
                'status'   => true,
                'message'  => 'Data Get Successfully',
                'response' => array('products' => $catData, 'coupons' => $coupon ,'is_online' => $vendorsOnline->is_online)

            ], 200);
        } catch (Throwable $th) {
            return response()->json([
                'status' => false,
                'error'  => $th->getMessage()
            ], 500);
        }
    }
    
    public function getTopRatedRestaurant(Request $request)
    {
        try {
            $validateUser = Validator::make(
                $request->all(),
                [
                    'lat'            => 'required|numeric',
                    'lng'            => 'required|numeric',
                    'offset'         => 'required|numeric',
                    'limit'          => 'required|numeric',
                ]
            );
            if ($validateUser->fails()) {
                $error = $validateUser->errors();
                return response()->json([
                    'status' => false,
                    'error'  => $validateUser->errors()->all()

                ], 401);
            }
            $vendor =  get_restaurant_near_me_v3($request->lat, $request->lng, ['vendor_type' => 'restaurant'], request()->user()->id, $request->offset, $request->limit);
            $vendor->orderBy('vendor_ratings',"DESC");
            $vendor = $vendor->get();
            foreach ($vendor as $key => $value) {
                if ($value->banner_image != '') {
                    $banners = @json_decode(@$value->banner_image);
                    if (is_array($banners))
                        $urlbanners = array_map(function ($banner) {
                            return URL::to('vendor-banner/') . '/' . $banner;
                        }, $banners);
                    else
                        $urlbanners = [];
                    $vendor[$key]->banner_image = $urlbanners;
                }
                $vendor[$key]->cuisines       = \App\Models\Cuisines::whereIn('cuisines.id', explode(',', $value->deal_cuisines))->pluck('name');
                $vendor[$key]->categories       = \App\Models\Catogory_master::whereIn('id', explode(',', $value->deal_categories))->pluck('name');
            }
            return response()->json([
                'status'   => true,
                'message'  => 'Data Get Successfully',
                'response' => $vendor

            ], 200);
            
            
        } catch (Throwable $th) {
            return response()->json([
                'status' => false,
                'error'  => $th->getMessage()
            ], 500);
        }
    }
    public function getTopRatedProducts(Request $request)
    {
        try {
            $validateUser = Validator::make(
                $request->all(),
                [
                    'lat'            => 'required|numeric',
                    'lng'            => 'required|numeric',
                    'offset'         => 'required|numeric',
                    'limit'          => 'required|numeric',
                ]
            );
            if ($validateUser->fails()) {
                $error = $validateUser->errors();
                return response()->json([
                    'status' => false,
                    'error'  => $validateUser->errors()->all()

                ], 401);
            }
            return $product =  topRatedProducts_v2($request->lat, $request->lng, request()->user()->id, $request->offset, $request->limit);
            
            return response()->json([
                'status'   => true,
                'message'  => 'Data Get Successfully',
                'response' => $product

            ], 200);
            
            
        } catch (Throwable $th) {
            return response()->json([
                'status' => false,
                'error'  => $th->getMessage()
            ], 500);
        }
    }

    public function tryOnesMoreRestaurant(Request $request)
    {
        try {
            $validateUser = Validator::make(
                $request->all(),
                [
                    'lat'            => 'required|numeric',
                    'lng'            => 'required|numeric'
                ]
            );
            if ($validateUser->fails()) {
                $error = $validateUser->errors();
                return response()->json([
                    'status' => false,
                    'error'  => $validateUser->errors()->all()

                ], 401);
            }
            $vendor = \App\Models\Order::tryOnesMoreVendors( 2 ,10, 'restaurant' ,$request->lat ,$request->lng);
            return response()->json([
                'status'   => true,
                'message'  => 'Data Get Successfully',
                'response' => $vendor

            ], 200);
            
            
        } catch (Throwable $th) {
            return response()->json([
                'status' => false,
                'error'  => $th->getMessage()
            ], 500);
        }
    }

    public function getRestauantMasterBlog(Request $request)
    {
        try {
            $validateUser = Validator::make(
                $request->all(),
                [
                    'lat'            => 'required|numeric',
                    'lng'            => 'required|numeric'
                ]
            );
            if ($validateUser->fails()) {
                $error = $validateUser->errors();
                return response()->json([
                    'status' => false,
                    'error'  => $validateUser->errors()->all()

                ], 401);
            }
            $Blogs         = \App\Models\AppPromotionBlogs::select('id', 'blog_type', 'name', 'from', 'to')
                ->where(function ($p) {
                    $p->where('from', '<=', mysql_date_time())->where('to', '>', mysql_date_time());
                })
                ->where(['vendor_type' => '1', 'blog_for' => '0'])
                ->get();
            $reponce =  promotionRowSetup($Blogs, $request, request()->user()->id);
            return response()->json([
                'status'   => true,
                'message'  => 'Data Get Successfully',
                'response' => $reponce

            ], 200);
            
        } catch (Throwable $th) {
            return response()->json([
                'status' => false,
                'error'  => $th->getMessage()
            ], 500);
        }
    }
    public function geMostViewVendors(Request $request)
    {
        try {
            $validateUser = Validator::make(
                $request->all(),
                [
                    'lat'            => 'required|numeric',
                    'lng'            => 'required|numeric'
                ]
            );
            if ($validateUser->fails()) {
                $error = $validateUser->errors();
                return response()->json([
                    'status' => false,
                    'error'  => $validateUser->errors()->all()

                ], 401);
            }
            $reponce = mostViewVendors($request->lat,$request->lng,request()->user()->id);
            if(count($reponce) >= 5){
                foreach ($reponce as $key => $value) {
                    if ($value->banner_image != '') {
                        $banners = @json_decode(@$value->banner_image);
                        if (is_array($banners))
                            $urlbanners = array_map(function ($banner) {
                                return URL::to('vendor-banner/') . '/' . $banner;
                            }, $banners);
                        else
                            $urlbanners = [];
                        $reponce[$key]->banner_image = $urlbanners;
                    }
                    $reponce[$key]->cuisines       = \App\Models\Cuisines::whereIn('cuisines.id', explode(',', $value->deal_cuisines))->pluck('name');
                    $reponce[$key]->categories       = \App\Models\Catogory_master::whereIn('id', explode(',', $value->deal_categories))->pluck('name');
                }
            }else{
                $reponce = [];
            }
            return response()->json([
                'status'   => true,
                'message'  => 'Data Get Successfully',
                'response' => $reponce

            ], 200);
            
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
                $data = get_restaurant_near_me($request->lat, $request->lng, ['vendor_type' => 'restaurant'], $request->user()->id, null, null, [], 'yes')
                    ->addSelect('review_count', 'deal_cuisines', 'fssai_lic_no', 'banner_image', 'vendor_food_type', 'table_service', 'start_time', 'end_time', 'table_service')
                    ->where('name', 'like', '%' . $request->keyword . '%')->skip($request->offset)->take(10)->get();
                // foreach ($data as $key => $value) {
                //     $data[$key]->next_available = next_available_day($value->id);
                // }
                foreach ($data as $key => $value) {
                    if ($value->banner_image != '') {
                        $banners = @json_decode(@$value->banner_image);
                        if (is_array($banners))
                            $urlbanners = array_map(function ($banner) {
                                return URL::to('vendor-banner/') . '/' . $banner;
                            }, $banners);
                        else
                            $urlbanners = [];
                        $data[$key]->banner_image = $urlbanners;
                    }
                    $data[$key]->cuisines       = \App\Models\Cuisines::whereIn('cuisines.id', explode(',', $value->deal_cuisines))->pluck('name');
                    $data[$key]->categories       = \App\Models\Catogory_master::whereIn('id', explode(',', $value->deal_categories))->pluck('name');
                    $data[$key]->next_available = next_available_day($value->id);

                }
            } elseif ($request->search_for == 'dishes') {
                $user_id = request()->user()->id;
                $select  = "6371 * acos(cos(radians(" . $request->lat . ")) * cos(radians(vendors.lat)) * cos(radians(vendors.long) - radians(" . $request->lng . ")) + sin(radians(" . $request->lat . ")) * sin(radians(vendors.lat))) ";
                $product = Product_master::where('products.status', '=', '1')->where('products.product_approve', '=', '1')->where('product_for', '=', '3')->where('product_name', 'LIKE', '%' . $request->keyword . '%')->where('vendors.status','=','1')->where('vendors.is_online','=','1')->where('available', 1);
                $product->join('vendors', 'products.userId', '=', 'vendors.id');
                $product = $product->leftJoin('user_product_like', function ($join) use ($user_id) {
                    $join->on('products.id', '=', 'user_product_like.product_id');
                    $join->where('user_product_like.user_id', '=', $user_id);
                });
                $product->leftJoin('vendor_order_time', function ($join) {
                    $join->on('vendor_order_time.vendor_id', '=', 'vendors.id')
                        ->where('vendor_order_time.day_no', '=', Carbon::now()->dayOfWeek)
                        ->where('start_time', '<=', mysql_time())
                        ->where('end_time', '>', mysql_time())
                        ->where('available', '=', 1);
                });
                $product = $product->leftJoin('vendor_offers', function ($join)  {
                        $join->on('products.userId', '=', 'vendor_offers.vendor_id');
                        $join->whereDate('vendor_offers.from_date','<=',date('Y-m-d'));
                        $join->whereDate('vendor_offers.to_date','>=',date('Y-m-d'));
                });
                $product->where(DB::raw("ROUND({$select})") ,'<=', config('custom_app_setting.near_by_distance'));
                $product = $product->Select(
                    DB::raw('products.userId as vendor_id'),
                    'preparation_time',
                    'chili_level',
                    'type',
                    'products.id as product_id',
                    'products.dis as description',
                    'products.product_name',
                    'product_price',
                    'customizable',
                     DB::raw('CONCAT("' . asset('products') . '/", product_image) AS image'),
                    'product_rating',
                    'primary_variant_name',
                    'products.menu_id',
                    'vendors.name as restaurantName',
                    DB::raw('if(user_product_like.user_id is not null, true, false)  as is_like'),
                    DB::Raw('IFNULL( vendor_offers.id , 0 ) as offer_id'),
                    DB::Raw('IFNULL( vendor_offers.offer_persentage , 0 ) as offer_persentage'),
                    DB::raw('
                    (CASE 
                        WHEN vendor_offers.id IS NOT NULL THEN product_price-product_price/100*vendor_offers.offer_persentage
                            ELSE `product_price`
                        END) as after_offer_price'
                    )
                );
                $data = $product->get();
                $cart = \App\Models\Cart::where('user_id', $user_id)->first();
                if (count($data->toArray())) {
                    foreach ($data as $i => $p) {
                        $qty = 0;
                        if (isset($cart->id) && $cart->id != '') {
                            $cart_p = \App\Models\CartProduct::where('cart_id', $cart->id)->where('product_id', $p['product_id'])->selectRaw('SUM(product_qty) as product_qty,id')->groupBy('product_id')->first();
                            if (isset($cart_p->product_qty)) {
                                $qty          = $cart_p->product_qty;
                            }
                        }
                        $data[$i]['cart_qty'] = $qty;
                    }
                }
                
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
    public function searchRestaurantDetailPage(Request $request)
    {
        try {
            $validateUser = Validator::make(
                $request->all(),
                [
                    'vendor_id' => 'required|numeric',
                    'keyword'   => 'required'
                ]
            );
            if ($validateUser->fails()) {
                $error = $validateUser->errors();
                return response()->json([
                    'status' => false,
                    'error'  => $validateUser->errors()->all()

                ], 401);
            }
            $variant = get_product_with_variant_and_addons_v3(['product_for' => '3','userId' => $request->vendor_id ], request()->user()->id, '', '', false,false,null,null,null,false,false,$request->keyword);
            
            return response()->json([
                'status'   => true,
                'message'  => 'Data Get Successfully',
                'response' => $variant

            ], 200);
        } catch (Throwable $th) {
            return response()->json([
                'status' => false,
                'error'  => $th->getMessage()
            ], 500);
        }
    }

    function getRestaurantDetailByFoodtype(Request $request){
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
                $product       = get_product_with_variant_and_addons_v3(
                    $product_where,
                    request()->user()->id,
                    null,
                    null,
                    $with_restaurant_name = true,
                    $is_chefleb_product = false,
                    $where_vendor_in = null,
                    null,
                    null,
                    $return_total_count = false
                );
                $data[$key] = array('menuName' => $value->menuName, 'id' => $value->id, 'products' => $product);

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

    public function getAllLikeProducts(Request $request){
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
            $product_ids = UserProductLike::where('user_id', $request->user()->id)->pluck('product_id');
            if(!empty($product_ids)){
                $data = get_product_with_variant_and_addons_v3(['product_for' => '3'], request()->user()->id, '', '', false,false,null,null,null,false,$product_ids);

            }else{
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
}

