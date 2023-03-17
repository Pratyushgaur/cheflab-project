<?php

namespace App\Http\Controllers\vendor\restaurant;

use App\Events\OrderSendToPrepareEvent;
use App\Events\OrderReadyToDispatchEvent;
use App\Events\OrderCancelDriverEmitEvent;
use App\Http\Controllers\Controller;
use App\Models\AdminMasters;
use App\Models\Order;
use App\Models\Vendors;
use App\Models\OrderProduct;
use App\Models\Product_master;
use Auth;
use Config;
use DataTables;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index($staus_filter = null)
    { 
        $orders = [];
        $order_obj = Order::select('orders.id', 'vendor_id', 'customer_name', 'delivery_address', 'order_status', 'total_amount', 'gross_amount', 'net_amount', 'discount_amount', 'payment_type', 'payment_status', 'preparation_time_to', 'order_products.product_name')
            ->join('users', 'users.id', '=', 'orders.user_id')
            ->join('order_products', 'order_products.order_id', '=', 'orders.id')
            ->join('products', 'products.id', '=', 'order_products.product_id')
            ->where('vendor_id', Auth::guard('vendor')->user()->id)
            ->whereNotIn('order_status', ['pending', 'cancelled_by_customer_before_confirmed']);
        if (in_array($staus_filter, ['confirmed', 'preparing', 'ready_to_dispatch', 'dispatched', 'cancelled_by_vendor', 'completed']) != '') {
            $order_obj->where('order_status', $staus_filter);
        }
        if (in_array($staus_filter, ['refunded']) != '') {
            $order_obj->where('refund', 2);
        }

        $orders = $order_obj
            ->groupBy('orders.id')
            ->orderBy('orders.id', 'desc')
            ->paginate(10);
        //        dd($orders);
        return view('vendor.restaurant.order.list', compact('orders', 'staus_filter'));
    }

    public function order_accept($id)
    {
        // createPdf($id);
        $order               = Order::find($id);
        $order->order_status = 'accepted';
        $order->save();
        \App\Jobs\OrderPreparationDoneJob::dispatch($order);


        return response()->json([
            'status'       => 'success',
            'order_status' => 'Accepted',
            'msg'          => "# $id accepted"
        ], 200);
    }

    public function order_vendor_reject($id)
    {
        $order               = Order::find($id);
        $order->order_status = 'cancelled_by_vendor';
        $order->save();
        \App\Models\OrderActionLogs::create(['orderid'=> $id,'action' => 'Order Rejected by vendor']);

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
        return response()->json([
            'status'       => 'success',
            'order_status' => 'cancelled_by_vendor',
            'msg'          => "# $id Order Cancelled"
        ], 200);
    }

    public function order_preparing(Request $request, $id)
    {
        // createPdf($id);
        \App\Models\OrderActionLogs::create(['orderid'=> $id,'action' => 'Order Accept By Vendor']);
        $order                        = Order::find($id);
        if($order->order_status == 'confirmed'){
            $order->order_status          = 'preparing';
            $order->preparation_time_from = mysql_date_time();
            $order->preparation_time_to   = mysql_add_time($order->preparation_time_from, $request->preparation_time);
            $order->save();
            event(new OrderSendToPrepareEvent($order, $request->preparation_time));
            return redirect()->back()->with('success', "# $id Order send for preparing");
        }else{
            return redirect()->back()->with('error', "Order is in Wrong Status");

        }
        
    }

    // public function order_need_more_time(Request $request, $id)
    // {
    //     $order                  = Order::find($id);
    //     $total_preparation_time = time_diffrence_in_minutes($order->preparation_time_from, $order->preparation_time_to);
    //     $admin_masters          = AdminMasters::select('max_preparation_time')->find(config('custom_app_setting.admin_master_id'));
    //     $a                      = ($admin_masters->max_preparation_time - $total_preparation_time);
    //     $p                      = (int)$request->extend_preparation_time;

    //     if ($total_preparation_time < $admin_masters->max_preparation_time) {
    //         if ($a > $p) {
    //             $order->order_status        = 'preparing';
    //             $order->is_need_more_time   = 1;
    //             $order->preparation_time_to = mysql_add_time($order->preparation_time_to, $request->extend_preparation_time);
    //             $order->save();
    //             return redirect()->back()->with('success', "# $order->order_id Order send for preparing");
    //         }

    //         return redirect()->back()->with('error', "Preparation time could be extend for order#$id. Because 'extend preparation time' is grater then admin 'max Preparation time'.");
    //     }
    //     return redirect()->back()->with('error', "Preparation time could be extend for order#$id. Because 'Total preparation' is grater then admin 'max Preparation time'.");
    // }
    public function order_need_more_time(Request $request, $id)
    {
        $order                      = Order::find($id);
        $order->preparation_time_to = mysql_add_time($order->preparation_time_to, $request->preparation_time);
        $order->is_need_more_time   = 1;
        $order->save();
        return redirect()->back()->with('success', "# $order->order_id Order Preparing time extended");
    }

    public function order_ready_to_dispatch($id)
    {

        // orderDeliverd($id);
        createPdf($id);
        $order               = Order::find($id);
        $order->order_status = 'ready_to_dispatch';
        $order->save();
        \App\Models\OrderActionLogs::create(['orderid'=> $id,'action' => 'Order Ready for Dispatch']);

        $otp = rand(1000, 9999);
        if ($order->accepted_driver_id != null) {
            event(new OrderReadyToDispatchEvent($id, $order->accepted_driver_id, $otp));
        }
        
        return response()->json([
            'status'       => 'success',
            'order_status' => 'ready_to_dispatch',
            'msg'          => "# $id Order ready to dispatch.",
            'otp'          => $otp
        ], 200);
    }

    public function order_dispatched($id)
    {

        $order               = Order::find($id);
        $order->order_status = 'dispatched';
        $order->save();
        \App\Models\OrderActionLogs::create(['orderid'=> $id,'action' => 'Order Dispatched']);
        //orderCancel($id);
        return response()->json([
            'status'       => 'success',
            'order_status' => 'dispatched',
            'msg'          => "# $id Order has been dispatched."
        ], 200);
    }

    public function view($id)
    {
        $order = Order::with('products', 'user', 'order_product_details')->where('vendor_id','=',Auth::guard('vendor')->user()->id)->findOrFail($id);
        $coupon = \App\Models\Coupon::find($order->coupon_id);

        if (!$order)
            return redirect()->back()->with('error', 'Order not found');

//        $rider=RiderAssignOrders::with('deliver_boy')->where('order_id',$id)->get();
//        dd($order);
        return view('vendor.restaurant.order.view', compact('order','coupon'));
    }

    public function invoice($id)
    {
        $order = Order::with('products', 'user', 'order_product_details')->where('vendor_id','=',Auth::guard('vendor')->user()->id)->find($id);
        $vendorData = Vendors::where('id', Auth::guard('vendor')->user()->id)->first();
            //    dd($order->toArray());
        $strtotime = strtotime($order->created_at);
        $order_date = date('d M Y h:m a',$strtotime);
        
        if (!$order)
            return redirect()->back()->with('error', 'Order not found');
            $rider = \App\Models\RiderAssignOrders::where('order_id','=',$order->id)->whereIn('action',["1","4","3"])->first();
        return view('vendor.restaurant.order.invoice', compact('order','rider','order_date','vendorData'));
    }

    public function qot($id)
    {
      
        $order = Order::with('products', 'user', 'order_product_details')->where('vendor_id','=',Auth::guard('vendor')->user()->id)->find($id);

        $product_qty = OrderProduct::where('order_id', $id)->get()->count();
        $strtotime = strtotime($order->created_at);
        $order_date = date('d M Y h:m a',$strtotime);
        if (!$order)
            return redirect()->back()->with('error', 'Order not found');
            $rider = \App\Models\RiderAssignOrders::where('order_id','=',$order->id)->whereIn('action',["1","4","3"])->first();
        return view('vendor.restaurant.order.qot', compact('order','rider','product_qty','order_date'));
    }

    public function get_preparation_time(Request $request)
    {
        //        $products       = OrderProduct::selectRaw('SUM(preparation_time) as total_preparation_time')->join('products', 'order_products.product_id', '=', 'products.id')->where('order_id', $request->order_id)->first();
        $products       = get_order_preparation_time($request->order_id);
        $admin_masters  = AdminMasters::select('max_preparation_time')->find(config('custom_app_setting.admin_master_id'));
        $is_extend_time = false;
        //$return         = ['total_preparation_time' => $products->total_preparation_time, 'is_extend_time' => false];
        $return         = ['total_preparation_time' => $admin_masters->max_preparation_time, 'is_extend_time' => false];
        // if ($products->total_preparation_time <= $admin_masters->max_preparation_time) {
        //     $return['is_extend_time']       = true;
        //     $return['max_preparation_time'] = ($admin_masters->max_preparation_time - $products->total_preparation_time);
        // }
        return response()->json($return, 200);
    }

    public function get_set_preparation_time(Request $request)
    {
        //        dd("sdfsdf");
        //        $products       = OrderProduct::selectRaw('SUM(preparation_time) as total_preparation_time')->join('products', 'order_products.product_id', '=', 'products.id')->where('order_id', $request->order_id)->first();
        //        $products=get_order_preparation_time($request->order_id);
        $order                  = Order::find($request->order_id);
        $total_preparation_time = time_diffrence_in_minutes($order->preparation_time_from, $order->preparation_time_to);
        $admin_masters          = AdminMasters::select('max_preparation_time')->find(config('custom_app_setting.admin_master_id'));
        $is_extend_time         = false;
        $return                 = ['total_preparation_time' => $total_preparation_time, 'is_extend_time' => false];
        //        if ($total_preparation_time <= $admin_masters->max_preparation_time) {
        //            $return['is_extend_time']       = true;
        //            $return['max_preparation_time'] = ($admin_masters->max_preparation_time - $total_preparation_time);
        //        }
        if ($total_preparation_time <= $admin_masters->max_preparation_time) {
            $return['max_preparation_time'] = ($admin_masters->max_preparation_time - $total_preparation_time);
            $options                        = "";
            if ($return['max_preparation_time'] >= 5) {
                $return['is_extend_time'] = true;
                $options                  .= "<option value='5'>5</option>";
            }
            if ($return['max_preparation_time'] >= 10) {
                $options .= "<option value='10'>10</option>";
            }
            if ($return['max_preparation_time'] >= 15) {
                $options .= "<option value='15'>15</option>";
            }
            $return['options'] = $options;
        }
        return response()->json($return, 200);
    }

    public function refresh_list(Request $request, $staus_filter = null)
    {
        $order_obj = Order::select('orders.id', 'orders.order_id', 'vendor_id', 'customer_name', 'delivery_address', 'order_status', 'total_amount', 'gross_amount', 'net_amount', 'discount_amount', 'payment_type', 'payment_status', 'preparation_time_to', 'order_products.product_name','orders.created_at','orders.pickup_otp')
            ->join('users', 'users.id', '=', 'orders.user_id')
            ->join('order_products', 'order_products.order_id', '=', 'orders.id')
            ->join('products', 'products.id', '=', 'order_products.product_id')
            ->where('vendor_id', Auth::guard('vendor')->user()->id)
            ->whereNotIn('order_status', ['pending', 'cancelled_by_customer_before_confirmed']);
        if (in_array($staus_filter, ['confirmed', 'preparing', 'ready_to_dispatch', 'dispatched', 'cancelled_by_vendor', 'completed']) != '') {
            $order_obj->where('order_status', $staus_filter);
        }
        if (in_array($staus_filter, ['refunded']) != '') {
            $order_obj->where('refund', 2);
        }

        $orders = $order_obj
            ->groupBy('orders.id')
            ->orderBy('orders.id', 'desc')
            ->paginate(10);
        //        dd($orders);
        return view('vendor.restaurant.order.refresh_list', compact('orders', 'staus_filter'));
    }
}
