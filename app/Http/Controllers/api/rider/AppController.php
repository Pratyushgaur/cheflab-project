<?php

namespace App\Http\Controllers\api\rider;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\RiderAssignOrders;
use App\Models\OrderProduct;
use App\Models\Deliver_boy;
use App\Models\DeliveryBoyTokens;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use PDOException;
use Throwable;
use URL;
use Validator;
class AppController extends Controller
{
    public function home(Request $request)
    {
        try {
            $validateUser = Validator::make(
                $request->all(),
                [
                    'user_id' => 'required|numeric'
                ]
            );
            if ($validateUser->fails()) {
                $error = $validateUser->errors();
                return response()->json([
                    'status' => false,
                    'error'  => $validateUser->errors()->all()

                ], 401);
            }

            $order = RiderAssignOrders::where(['rider_id' =>$request->user_id,'action' =>'0'])->orWhere(['rider_id' =>$request->user_id,'action' =>'1'])->orderBy('rider_assign_orders.id','desc')->limit(1);
            $order = $order->join('orders','rider_assign_orders.order_id','=','orders.id');
            $order = $order->join('vendors','orders.vendor_id','=','vendors.id');
            $order = $order->select('vendors.name as vendor_name','vendors.address as vendor_address','orders.customer_name','orders.delivery_address',DB::raw('if(rider_assign_orders.action = "1", "accepted", "pending")  as rider_status'),'action','orders.id as order_row_id','orders.order_id');
           
            if ($order->first()->action == '0') {
                $order = $order->first();
                $order->expected_earninig = 50;
                $order->trip_distance = 7;
            } else {
                $order = $order->addSelect('vendors.mobile as vendor_mobile','vendors.lat as vendor_lat','vendors.long as vendor_lng','orders.lat as customer_lat','orders.long as customer_lng','orders.mobile_number as customer_mobile','net_amount',);
                $order = $order->leftJoin('order_products', 'orders.id', '=', 'order_products.order_id');
                $order = $order->first();
                $order->products = OrderProduct::where('order_id','=',$order->order_row_id)->join('products','order_products.product_id','=','products.id')->leftJoin('order_product_variants','order_products.id','=','order_product_variants.order_product_id')->select('order_products.product_name','order_product_variants.variant_name','products.type')->get();
            }
            $data = Deliver_boy::where('id','=',$request->user_id)->select('name','email','username','mobile','is_online',\DB::raw('CONCAT("' . asset('dliver-boy') . '/", image) AS image'))->first();
            return response()->json([
                'status'   => true,
                'message'  => 'Data Get Successfully',
                'response' => ['orders'=>$order,'profile'=>$data]

            ], 200);
        } catch (Throwable $th) {
            return response()->json([
                'status' => false,
                'error'  => $th->getMessage()
            ], 500);
        }
    }

    public function profile(Request $request)
    {
        try {
            $validateUser = Validator::make(
                $request->all(),
                [
                    'user_id' => 'required|numeric'
                ]
            );
            if ($validateUser->fails()) {
                $error = $validateUser->errors();
                return response()->json([
                    'status' => false,
                    'error'  => $validateUser->errors()->all()

                ], 401);
            }
            $data = Deliver_boy::where('id','=',$request->user_id)->select('name','email','username','mobile','is_online',\DB::raw('CONCAT("' . asset('dliver-boy') . '/", image) AS image'));
            if($data->exists()){
                $data = $data->first();   
                return response()->json([
                    'status'   => true,
                    'message'  => 'Data Get Successfully',
                    'response' => $data
    
                ], 200);  
            }else{
                return response()->json([
                    'status'   => false,
                    'error'  => 'No User Found'
    
                ], 500);
            }
                       
            
           
        } catch (Throwable $th) {
            return response()->json([
                'status' => false,
                'error'  => $th->getMessage()
            ], 500);
        }
    }

    public function register_token(Request $request)
    {
        try {
            $validateUser = Validator::make(
                $request->all(),
                [
                    'user_id' => 'required|numeric',
                    'token'   => 'required'
                ]
            );
            if ($validateUser->fails()) {
                $error = $validateUser->errors();
                return response()->json([
                    'status' => false,
                    'error'  => $validateUser->errors()->all()

                ], 401);
            }
            if(!DeliveryBoyTokens::where(['rider_id'=>$request->user_id,'token'=>$request->token])->exists())
            {
                $DeliveryBoyTokens = new DeliveryBoyTokens;
                $DeliveryBoyTokens->rider_id = $request->user_id;
                $DeliveryBoyTokens->token = $request->token;
                $DeliveryBoyTokens->saveOrFail();
            }
            return response()->json([
                'status'   => true,
                'message'  => 'Token Register Successfully'

            ], 200);  
                       
            
           
        } catch (Throwable $th) {
            return response()->json([
                'status' => false,
                'error'  => $th->getMessage()
            ], 500);
        }
    }
    public function orderStatus(Request $request)
    {
        try {
            $validateUser = Validator::make(
                $request->all(),
                [
                    'order_row_id' => 'required|numeric',
                    'status'   => 'required'
                ]
            );
            if ($validateUser->fails()) {
                $error = $validateUser->errors();
                return response()->json([
                    'status' => false,
                    'error'  => $validateUser->errors()->all()

                ], 401);
            }
            RiderAssignOrders::where('order_id','=',$request->order_row_id)->update(['action'=>$request->status]);
            $order = [];
            if ($request->status == '1') {
                $order = RiderAssignOrders::where('rider_assign_orders.order_id','=',$request->order_row_id);
                $order = $order->join('orders','rider_assign_orders.order_id','=','orders.id');
                $order = $order->join('vendors','orders.vendor_id','=','vendors.id');
                $order = $order->select('vendors.name as vendor_name','vendors.address as vendor_address','orders.customer_name','orders.delivery_address',DB::raw('if(rider_assign_orders.action = "1", "accepted", "pending")  as rider_status'),'action','orders.id as order_row_id','orders.order_id');
                $order = $order->addSelect('vendors.mobile as vendor_mobile','vendors.lat as vendor_lat','vendors.long as vendor_lng','orders.lat as customer_lat','orders.long as customer_lng','orders.mobile_number as customer_mobile','net_amount',);
                $order = $order->leftJoin('order_products', 'orders.id', '=', 'order_products.order_id');
                $order = $order->first();
                $order->products = OrderProduct::where('order_id','=',$order->order_row_id)->join('products','order_products.product_id','=','products.id')->leftJoin('order_product_variants','order_products.id','=','order_product_variants.order_product_id')->select('order_products.product_name','order_product_variants.variant_name','products.type')->get();
            }
            return response()->json([
                'status'   => true,
                'message'  => 'Status Updated Successfully',
                'order'    => $order

            ], 200);    
            
           
        } catch (Throwable $th) {
            return response()->json([
                'status' => false,
                'error'  => $th->getMessage()
            ], 500);
        }
    }
}
