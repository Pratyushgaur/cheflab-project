<?php

namespace App\Http\Controllers\api\vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vendors;
use App\Models\Product_master;
use App\Models\Order;
use App\Models\AdminMasters;
use App\Events\OrderSendToPrepareEvent;
use App\Events\OrderReadyToDispatchEvent;
use App\Events\OrderCancelDriverEmitEvent;
use Validator;
class HomeApiController extends Controller
{
    function index(Request $request) {
        try {
            
            $orders = Order::where('vendor_id', $request->user()->id)->whereNotIn('order_status', ['pending','cancelled_by_customer_before_confirmed','cancelled_by_customer_after_confirmed','cancelled_by_customer_during_prepare','cancelled_by_customer_after_disptch','cancelled_by_vendor','completed','dispatched'])->orderBy('id','desc')->skip(0)->take(20)->get();
            $admin_masters  = AdminMasters::select('max_preparation_time')->find(config('custom_app_setting.admin_master_id'));
            
            //
            return response()->json([
                'status'   => true,
                'message'  => 'Successfully',
                'response' => ['orders' => $orders,"prepration_time" => $admin_masters->max_preparation_time]
                
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
                'preparation_time' =>'required|numeric'
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
    function order_vendor_reject(Request $request) {
        try {
            $validateUser = Validator::make($request->all(), [
                'order_id' => 'required|numeric||exists:orders,id'
            ]);
            if ($validateUser->fails()) {
                $error = $validateUser->errors();
                return response()->json(['status' => false, 'error' => $validateUser->errors()->all()], 401);
            }

            $id = $request->order_id;
            $order               = Order::find($id);
            $order->order_status = 'cancelled_by_vendor';
            $order->save();
            \App\Models\OrderActionLogs::create(['orderid'=> $id,'action' => 'Order Rejected by vendor from app']);
            //
            $user                = \App\Models\User::find($order->user_id);
            $user->wallet_amount = $user->wallet_amount + $order->net_amount;
            $user->save();
            $UserWalletTransactions = new \App\Models\UserWalletTransactions;
            $UserWalletTransactions->user_id = $order->user_id;
            $UserWalletTransactions->amount = $order->net_amount;
            $UserWalletTransactions->transaction_id = $order->order_id;
            $UserWalletTransactions->narration = "Refund";
            $UserWalletTransactions->save();
            if ($order->accepted_driver_id != null) {
                event(new OrderCancelDriverEmitEvent($order, $order->accepted_driver_id));
            }
            orderCancelByVendor($id);
            $data = orderDetailForUser($id);
            \App\Jobs\UserOrderNotification::dispatch('Order Cancelled By Restaurant', 'Your Order id #'.$order->order_id.' is Cancelled By Restaurant.', $user->fcm_token, 7, $data);
            return response()->json(['status' => true, 'message' => "# $id Order Cancelled"], 200);
            
        } catch (Throwable $th) {
            return response()->json([
                'status' => false,
                'error'  => $th->getMessage()
            ], 500);
        }

    }
    function ready_to_dispatch(Request $request) {
        try {
            $validateUser = Validator::make($request->all(), [
                'order_id' => 'required|numeric||exists:orders,id'
            ]);
            if ($validateUser->fails()) {
                $error = $validateUser->errors();
                return response()->json(['status' => false, 'error' => $validateUser->errors()->all()], 401);
            }

            $id = $request->order_id;
            $order               = Order::find($id);
            createPdf($id);
            if($order->order_status == 'preparing'){
                $order->order_status = 'ready_to_dispatch';
                $order->save();
                \App\Models\OrderActionLogs::create(['orderid'=> $id,'action' => 'Order Ready for Dispatch From App']);
    
                $otp = rand(1000, 9999);
                if ($order->accepted_driver_id != null) {
                    event(new OrderReadyToDispatchEvent($id, $order->accepted_driver_id, $otp));
                }
                
                return response()->json(['status' => true, 'message' => "# $id Order ready to dispatch."], 200);

            }else{
                return response()->json(['status' => false, 'error' => "Something Went Wrong With Order status"], 401);
                 
            }
            
        } catch (Throwable $th) {
            return response()->json([
                'status' => false,
                'error'  => $th->getMessage()
            ], 500);
        }
    }
}
