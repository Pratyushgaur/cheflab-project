<?php

namespace App\Http\Controllers\api\vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vendors;
use App\Models\Product_master;
use App\Models\Order;
use App\Events\OrderSendToPrepareEvent;
use App\Events\OrderReadyToDispatchEvent;
use App\Events\OrderCancelDriverEmitEvent;
class HomeApiController extends Controller
{
    function index(Request $request) {
        try {
            
            $orders = Order::where('vendor_id', $request->user()->id)->whereNotIn('order_status', ['pending','cancelled_by_customer_before_confirmed','cancelled_by_customer_after_confirmed','cancelled_by_customer_during_prepare','cancelled_by_customer_after_disptch','cancelled_by_vendor','completed','dispatched'])->orderBy('id','desc')->skip(0)->take(20)->get();

            //
            return response()->json([
                'status'   => true,
                'message'  => 'Successfully',
                'response' => $orders
                
            ], 200);
        } catch (Throwable $th) {
            return response()->json([
                'status' => false,
                'error'  => $th->getMessage()
            ], 500);
        }

    }
    function order_preparing(Request $request) {
        try {
            $validateUser = Validator::make($request->all(), [
                'order_id' => 'required|numeric||exists:orders,id',
                'preparation_time' =>'required|numaric'
            ]);
            if ($validateUser->fails()) {
                $error = $validateUser->errors();
                return response()->json(['status' => false, 'error' => $validateUser->errors()->all()], 401);
            }

            $id = $request->order_id;
            \App\Models\OrderActionLogs::create(['orderid'=> $id,'action' => 'Order Accept By Vendor from App']);
            $order                        = Order::find($id);
            if($order->order_status == 'confirmed'){
                $order->order_status          = 'preparing';
                $order->preparation_time_from = mysql_date_time();
                $order->preparation_time_to   = mysql_add_time($order->preparation_time_from, $request->preparation_time);
                $order->save();
                event(new OrderSendToPrepareEvent($order, $request->preparation_time));
                return response()->json(['status' => true, 'message' => "#$order->order_id Order send for preparing"], 200);

            }else{
                return response()->json(['status' => false, 'error' => 'Order Status Already Confimed'], 401);
                
            }

           
        } catch (Throwable $th) {
            return response()->json([
                'status' => false,
                'error'  => $th->getMessage()
            ], 500);
        }

    }
}
