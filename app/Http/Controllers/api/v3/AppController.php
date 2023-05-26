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
            $vendor =  get_restaurant_near_me_v3($request->lat, $request->lng, ['vendor_type' => 'restaurant'], request()->user()->id, $request->offset, $request->limit);
            $vendor->orderBy('vendor_ratings',"DESC");
            $vendor = $vendor->get();
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

}
