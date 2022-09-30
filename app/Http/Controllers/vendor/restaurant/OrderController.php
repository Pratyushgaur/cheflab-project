<?php

namespace App\Http\Controllers\vendor\restaurant;

use App\Events\OrderSendToPrepareEvent;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Auth;
use Config;
use DataTables;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::select('orders.id','vendor_id','customer_name','delivery_address','order_status','total_amount','gross_amount','net_amount','discount_amount','payment_type','payment_status','order_products.product_name')
            ->join('users', 'users.id', '=', 'orders.user_id')
            ->join('order_products', 'order_products.order_id', '=', 'orders.id')
            ->join('products', 'products.id', '=', 'order_products.product_id')
            ->where('vendor_id',Auth::guard('vendor')->user()->id)
            ->groupBy('orders.id')
            ->orderBy('orders.id', 'desc')
            ->paginate(25);
//        dd($orders);
        return view('vendor.restaurant.order.list', compact('orders'));
    }

    public function order_accept($id){
        $order=Order::find($id);
        $order->order_status='accepted';
        $order->save();
        return response()->json([
            'status' => 'success',
            'order_status' => 'Accepted',
            'msg' => "# $id accepted"
        ], 200);
    }

    public function order_vendor_reject($id){
        $order=Order::find($id);
        $order->order_status='cancelled_by_vendor';
        $order->save();
        return response()->json([
            'status' => 'success',
            'order_status' => 'cancelled_by_vendor',
            'msg' => "# $id Order Cancelled"
        ], 200);
    }

    public function order_preparing(Request $request,$id){
        $order=Order::find($id);
        $order->order_status='preparing';
        $order->preparation_time_from=mysql_date_time();
        $order->preparation_time_to=mysql_add_time($order->preparation_time_from,$request->preparation_time);
        $order->save();
        event(new OrderSendToPrepareEvent($id,$order->user_id,$order->vendor_id,$request->preparation_time));
        return redirect()->back()->with('success', "# $id Order send for preparing");

    }

    public function order_ready_to_dispatch($id){
        $order=Order::find($id);
        $order->order_status='ready_to_dispatch';
        $order->save();
        return response()->json([
            'status' => 'success',
            'order_status' => 'ready_to_dispatch',
            'msg' => "# $id Order ready to dispatch."
        ], 200);
    }

    public function order_dispatched($id){
        $order=Order::find($id);
        $order->order_status='dispatched';
        $order->save();
        return response()->json([
            'status' => 'success',
            'order_status' => 'dispatched',
            'msg' => "# $id Order has been dispatched."
        ], 200);
    }

    public function view($id){
        $order=Order::with('products','user','order_product_details')->find($id);
        if(!$order)
            return redirect()->back()->with('error', 'Order nOt found');
//        dd($order);
        return view('vendor.restaurant.order.view', compact('order'));
    }
}
