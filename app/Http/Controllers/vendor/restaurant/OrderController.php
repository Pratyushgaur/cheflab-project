<?php

namespace App\Http\Controllers\vendor\restaurant;

use App\Events\OrderSendToPrepareEvent;
use App\Http\Controllers\Controller;
use App\Models\AdminMasters;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\RiderAssignOrders;
use Auth;
use Config;
use DataTables;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index($staus_filter=null)
    {

        $order_obj= Order::select('orders.id', 'vendor_id', 'customer_name', 'delivery_address', 'order_status', 'total_amount', 'gross_amount', 'net_amount', 'discount_amount', 'payment_type', 'payment_status','preparation_time_to', 'order_products.product_name')
        ->join('users', 'users.id', '=', 'orders.user_id')
        ->join('order_products', 'order_products.order_id', '=', 'orders.id')
        ->join('products', 'products.id', '=', 'order_products.product_id')
        ->where('vendor_id', Auth::guard('vendor')->user()->id)
        ->whereNotIn('order_status',['pending','cancelled_by_customer_before_confirmed']);
        if(in_array($staus_filter,['confirmed','preparing','ready_to_dispatch','dispatched','cancelled_by_vendor','completed'])!='')
        {
            $order_obj->where('order_status',$staus_filter);
        }
        if(in_array($staus_filter,['refunded'])!='')
        {
            $order_obj->where('refund',2);
        }

        $orders =$order_obj
            ->groupBy('orders.id')
            ->orderBy('orders.id', 'desc')
            ->paginate(25);
//        dd($orders);
        return view('vendor.restaurant.order.list', compact('orders'));
    }

    public function order_accept($id)
    {
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
        return response()->json([
            'status'       => 'success',
            'order_status' => 'cancelled_by_vendor',
            'msg'          => "# $id Order Cancelled"
        ], 200);
    }

    public function order_preparing(Request $request, $id)
    {
        $order                        = Order::find($id);
        $order->order_status          = 'preparing';
        $order->preparation_time_from = mysql_date_time();
        $order->preparation_time_to   = mysql_add_time($order->preparation_time_from, $request->preparation_time);
        $order->save();
//        event(new OrderSendToPrepareEvent($id, $order->user_id, $order->vendor_id, $request->preparation_time));
        event(new OrderSendToPrepareEvent($order, $request->preparation_time));
        \App\Jobs\OrderPreparationDoneJob::dispatch($order);
        return redirect()->back()->with('success', "# $id Order send for preparing");

    }

    public function order_ready_to_dispatch($id)
    {
        $order               = Order::find($id);
        $order->order_status = 'ready_to_dispatch';
        $order->save();
        return response()->json([
            'status'       => 'success',
            'order_status' => 'ready_to_dispatch',
            'msg'          => "# $id Order ready to dispatch."
        ], 200);
    }

    public function order_dispatched($id)
    {
        $order               = Order::find($id);
        $order->order_status = 'dispatched';
        $order->save();
        return response()->json([
            'status'       => 'success',
            'order_status' => 'dispatched',
            'msg'          => "# $id Order has been dispatched."
        ], 200);
    }

    public function view($id)
    {
        $order = Order::with('products', 'user', 'order_product_details','rider_assign_orders')->find($id);
//        dd($order);
        if (!$order)
            return redirect()->back()->with('error', 'Order not found');

//        $rider=RiderAssignOrders::with('deliver_boy')->where('order_id',$id)->get();
//        dd($order);
        return view('vendor.restaurant.order.view', compact('order'));
    }

    public function invoice($id)
    {
        $order = Order::with('products', 'user', 'order_product_details')->find($id);
//        dd($order);
        if (!$order)
            return redirect()->back()->with('error', 'Order not found');
   return view('vendor.restaurant.order.invoice', compact('order'));
    }

    public function get_preparation_time(Request $request)
    {
//        $products       = OrderProduct::selectRaw('SUM(preparation_time) as total_preparation_time')->join('products', 'order_products.product_id', '=', 'products.id')->where('order_id', $request->order_id)->first();
        $products=get_order_preparation_time($request->order_id);
        $admin_masters  = AdminMasters::select('max_preparation_time')->find(config('custom_app_setting.admin_master_id'));
        $is_extend_time = false;
        $return         = [ 'total_preparation_time' => $products->total_preparation_time, 'is_extend_time' => false ];
        if ($products->total_preparation_time <= $admin_masters->max_preparation_time) {
            $return['is_extend_time']       = true;
            $return['max_preparation_time'] = ($admin_masters->max_preparation_time - $products->total_preparation_time);
        }
        return response()->json($return, 200);
    }
}
