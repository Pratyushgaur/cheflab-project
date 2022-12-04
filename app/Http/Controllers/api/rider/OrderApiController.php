<?php

namespace App\Http\Controllers\api\rider;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Deliver_boy;
use App\Models\AdminMasters;
use App\Models\RiderMobileOtp;
use App\Models\RiderAssignOrders;
use App\Models\OrderProduct;
use App\Models\OrderProductAddon;
use App\Models\OrderProductVariant;

use Validator;

class OrderApiController extends Controller
{
    public function orderhistory(Request $request)
    {
        try {
            $validateUser = Validator::make($request->all(),
            [
                'offset' => 'required|numeric',
                'user_id' => 'required|numeric'
            ]);
            if($validateUser->fails()){
                $error = $validateUser->errors();
                return response()->json([
                    'status' => false,
                    'error'=>$validateUser->errors()->all()

                ], 401);
            }
        
            $order = RiderAssignOrders::where('rider_id','=',$request->user_id);
            $order = $order->join('orders','rider_assign_orders.order_id','=','orders.id');
            $order = $order->join('vendors', 'orders.vendor_id', '=', 'vendors.id');
            $order = $order->skip($request->offset)->take(10);
            $order = $order->select('orders.customer_name',\DB::raw("DATE_FORMAT(orders.created_at, '%d/%b/%y %H:%i %p') as order_date"),'orders.id as order_id');
            

            // $order = Order::where('user_id', '=', request()->user()->id);
            // $order = $order->select(\DB::raw('CONCAT("' . asset('vendors') . '/", image) AS image'), 'orders.id as order_id', 'vendors.name as vendor_name', 'order_status', 'net_amount', 'payment_type', \DB::raw("DATE_FORMAT(orders.created_at, '%d %b %Y at %H:%i %p') as order_date"),'delivery_address','orders.lat','orders.long','vendors.lat as vendor_lat','vendors.long as vendor_lng','vendors.fssai_lic_no','vendors.address as vendor_address');
            // $order = $order->join('vendors', 'orders.vendor_id', '=', 'vendors.id');
            // $order = $order->where('vendors.vendor_type', '=', 'restaurant');
            // $order = $order->orderBy('orders.id', 'desc');
            // $order = $order->skip($request->offset)->take(10);
            $order = $order->get();

            foreach ($order as $key => $value) {
                $products              = OrderProduct::where('order_id', '=', $value->order_id)->join('products', 'order_products.product_id', 'products.id')->select('product_id', 'order_products.product_name', 'order_products.product_price', 'product_qty','order_products.id as order_product_id')->get();
                foreach($products as $k => $v){
                    $OrderProductAddon = OrderProductAddon::where('order_product_id','=',$v->order_product_id)->select('addon_name','addon_price','addon_qty')->get();
                    $OrderProductVariant = OrderProductVariant::where('order_product_id','=',$v->order_product_id)->select('variant_name','variant_price','variant_qty')->first();
                    if(!empty($OrderProductVariant)){
                        $products[$k]->variant = $OrderProductVariant;
                    }
                    if(!empty($OrderProductAddon->toArray())){
                        $products[$k]->addons = $OrderProductAddon;
                    }

                }
                $order[$key]->products = $products;
            }
            return response()->json([
                'status' => true,
                'message'=>'Otp Send Successfully',
                'response'=>$order
            ], 200);



        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'error' => $th->getMessage()
            ], 500);
        }
    }
    public function login_verify_otp(Request $request)
    {
        try {
            $validateUser = Validator::make($request->all(),
            [
                'mobile_number' => 'required|numeric|digits:10',
                'otp' => 'required|numeric|digits:4',
            ]);
            if($validateUser->fails()){
                $error = $validateUser->errors();
                return response()->json([
                    'status' => false,
                    'error'=>$validateUser->errors()->all()

                ], 401);
            }
            $insertedOtp = RiderMobileOtp::where(['mobile_number' =>$request->mobile_number])->first();
            if($insertedOtp->otp == $request->otp){
                RiderMobileOtp::where(['mobile_number' =>$request->mobile_number])->update(['status' =>'1']);
                $user = Deliver_boy::where('mobile','=',$request->mobile_number)->select('id','name','mobile','email')->first();
                $token = $user->createToken('cheflab-app-token')->plainTextToken;
                return response()->json([
                    'status' => true,
                    'message'=>'User Login Successfully',
                    'token'=>array('name' =>$user->name,'email'=>$user->email,'mobile'=>$user->mobile,'user_id'=>$user->id,'token'=>$token)
                ], 200);
            }else{
                return response()->json([
                    'status' => false,
                    'error'=>'Invalid OTP',
                ], 200);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'error' => $th->getMessage()
            ], 500);
        }

    }
    
}
