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
                'user_id' => 'required|numeric',
                'status' => 'required'
            ]);
            if($validateUser->fails()){
                $error = $validateUser->errors();
                return response()->json([
                    'status' => false,
                    'error'=>$validateUser->errors()->all()

                ], 401);
            }
        
            $order = RiderAssignOrders::where('rider_id','=',$request->user_id);
            if($request->status == 'completed'){
                $order = $order->where('action','=','3');
                
            }
            if($request->status == 'cancelled'){
                $order = $order->whereIn('action',['2','6']);
            }
            if($request->status == 'ongoing'){
                $order = $order->whereIn('action',['1','4']);
            }
            $order = $order->join('orders','rider_assign_orders.order_id','=','orders.id');
            $order = $order->join('vendors', 'orders.vendor_id', '=', 'vendors.id');
            $order = $order->skip($request->offset)->take(10);
            $order = $order->select('orders.customer_name',\DB::raw("DATE_FORMAT(orders.created_at, '%d/%b/%y %H:%i %p') as order_date"),'orders.order_id','orders.id as order_row_id','net_amount','rider_assign_orders.cancel_reason','rider_assign_orders.distance','rider_assign_orders.earning','send_cutlery','chef_message','avoid_ring_bell','leave_at_door','avoid_calling','direction_to_reach','direction_instruction','action');
            $order = $order->addSelect('vendors.name as vendor_name','vendors.mobile as vendor_mobile','vendors.lat as vendor_lat','vendors.long as vendor_lng','vendors.address as vendor_address','orders.lat as customer_lat','orders.long as customer_lng','orders.delivery_address','orders.mobile_number as customer_mobile');
            if($request->status == 'completed'){
                $order = $order->addSelect(\DB::raw("DATE_FORMAT(orders.pickup_time, '%h:%i %p, %d/%m/%y') as pickup_time"),\DB::raw("DATE_FORMAT(orders.delivered_time, '%h:%i %p, %d/%m/%y') as delivered_time"));
                //10:32 AM, 20/09/22
                
            }
            // $order = Order::where('user_id', '=', request()->user()->id);
            // $order = $order->select(\DB::raw('CONCAT("' . asset('vendors') . '/", image) AS image'), 'orders.id as order_id', 'vendors.name as vendor_name', 'order_status', 'net_amount', 'payment_type', \DB::raw("DATE_FORMAT(orders.created_at, '%d %b %Y at %H:%i %p') as order_date"),'delivery_address','orders.lat','orders.long','vendors.lat as vendor_lat','vendors.long as vendor_lng','vendors.fssai_lic_no','vendors.address as vendor_address');
            // $order = $order->join('vendors', 'orders.vendor_id', '=', 'vendors.id');
            // $order = $order->where('vendors.vendor_type', '=', 'restaurant');
            // $order = $order->orderBy('orders.id', 'desc');
            // $order = $order->skip($request->offset)->take(10);
            $order = $order->get();

            foreach ($order as $key => $value) {
                $products              = OrderProduct::where('order_id','=',$value->order_row_id)->join('products','order_products.product_id','=','products.id')->leftJoin('order_product_variants','order_products.id','=','order_product_variants.order_product_id')->select('order_products.product_name','order_products.product_qty','order_products.id as order_product_row_id','order_product_variants.variant_name','products.type','customizable')->get();
                foreach($products as $k =>$v ){
                    if($v->customizable == 'false'){
                        $products[$key]->variant_name = '';
                    }
                    $addons = \App\Models\OrderProductAddon::where('order_product_id','=',$v->order_product_row_id)->select('addon_name','addon_price','addon_qty')->get();
                    $products[$k]->addons = $addons;
                }
                
                $order[$key]->products = $products;
            }
            $profile = Deliver_boy::where('id','=',$request->user_id)->select('name','email','username','mobile','is_online',\DB::raw('CONCAT("' . asset('dliver-boy') . '/", image) AS image'))->first();
            return response()->json([
                'status' => true,
                'message'=>'data Get Successfully',
                'response'=>['order'=>$order,'profile'=>$profile]
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
