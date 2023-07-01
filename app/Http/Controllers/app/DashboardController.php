<?php

namespace App\Http\Controllers\app;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Auth;
use Validator;
use Hash;
use App\Models\Vendors;
use App\Models\Product_master;
use App\Models\Order;
use App\Events\OrderSendToPrepareEvent;
use App\Events\OrderReadyToDispatchEvent;



class DashboardController extends Controller
{
    public function index(Request $request)
    {   
        return view('vendor.vendor_app.dashboard');
    }
    public function order_preparing(Request $request )
    {
        // createPdf($id);
        parse_str($request->form_data,$data);
        
        $id = $data['order_id'];
        \App\Models\OrderActionLogs::create(['orderid'=> $id,'action' => 'Order Accept By Vendor']);
        $order                        = Order::find($id);
        if($order->order_status == 'confirmed'){
            $order->order_status          = 'preparing';
            $order->preparation_time_from = mysql_date_time();
            $order->preparation_time_to   = mysql_add_time($order->preparation_time_from, $data['preparation_time']);
            $order->save();
            event(new OrderSendToPrepareEvent($order, $data['preparation_time']));
            return array('status' =>true, 'message' => "#$order->order_id Order send for preparing");
        }else{
            return array('status' =>false, 'error' => "Order Status Already Confimed");
            
        }
        
    }
    public function order_ready_to_dispatch(Request $request)
    {

        // orderDeliverd($id);
        $id = $request->order_id;
        //createPdf($id);
        $order               = Order::find($id);
        if($order->order_status == 'preparing'){
            $order->order_status = 'ready_to_dispatch';
            $order->save();
            \App\Models\OrderActionLogs::create(['orderid'=> $id,'action' => 'Order Ready for Dispatch']);

            $otp = rand(1000, 9999);
            if ($order->accepted_driver_id != null) {
                event(new OrderReadyToDispatchEvent($id, $order->accepted_driver_id, $otp));
            }
            return array('status'=> true, 'message' => "#$order->order_id Order ready to dispatch."   );

        }else{
            return array('status' =>false, 'error' => "Order Status Already Confimed");

        }
        
    }
    public function refresh_list(Request $request)
    {
        $orders = Order::where('vendor_id', Auth::guard('vendor')->user()->id)->whereNotIn('order_status', ['pending','cancelled_by_customer_before_confirmed','cancelled_by_customer_after_confirmed','cancelled_by_customer_during_prepare','cancelled_by_customer_after_disptch','cancelled_by_vendor','completed','dispatched'])->orderBy('id','desc')->skip(0)->take(10)->get();
        return view('vendor.vendor_app.refresh_list',compact('orders'));

    }
}
