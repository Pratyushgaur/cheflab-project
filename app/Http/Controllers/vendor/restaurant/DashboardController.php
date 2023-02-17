<?php

namespace App\Http\Controllers\vendor\restaurant;

use App\Http\Controllers\Controller;
use App\Models\Orders;
use App\Models\Product_master;
use Auth;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {   
        //updateDriverLatLngFromFcm();
        // $order = Orders::find(1);
        // $vendor = \App\Models\Vendors::find($order->vendor_id);
        // $d = orderAssignToDeliveryBoy(24.46423226202339, 74.86663632553595,$order);
        // if(!empty($d)){
        //     $d = calculateRiderCharge($d->distance,$vendor->lat,$vendor->long,$order->lat,$order->long);
        //     dd($d);
            
        // }

        // dd($d->toArray());
        $product = Product_master::where('userId', '=', Auth::guard('vendor')->user()->id);
        $product = $product->select('products.product_name', 'products.id as product_id', 'product_image', 'product_price');
        $product = $product->addSelect(\DB::raw('(SELECT IFNULL(COUNT(order_products.id),0) as total FROM order_products join orders on order_products.order_id=orders.id WHERE  order_products.product_id =  products.id and orders.order_status="completed" ) AS orderTotal'));    
        $product = $product->orderBy('orderTotal', 'DESC')->having('orderTotal','>','0')->limit(4)->get();
        $text    = "Till Now";

        //order count
        \DB::enableQueryLog();
        $order_obj = Orders::where('vendor_id', Auth::guard('vendor')->user()->id);
        //$where = [['vendor_id', '=', Auth::guard('vendor')->user()->id]];
        $total_orders = Orders::where('vendor_id', Auth::guard('vendor')->user()->id)->whereNotIn('order_status', ['pending','cancelled_by_customer_before_confirmed']);
        $total_pending = Orders::where('vendor_id', Auth::guard('vendor')->user()->id)->where('order_status', 'confirmed');
        $total_dispatched        = Orders::where('vendor_id', Auth::guard('vendor')->user()->id)->where('order_status', 'dispatched');
        $total_ready_to_dispatch = Orders::where('vendor_id', Auth::guard('vendor')->user()->id)->where('order_status', 'ready_to_dispatch');
        $total_prepairing        = Orders::where('vendor_id', Auth::guard('vendor')->user()->id)->where('order_status', 'preparing');
        $total_completed         = Orders::where('vendor_id', Auth::guard('vendor')->user()->id)->where('order_status', 'completed');
        $total_rejected          = Orders::where('vendor_id', Auth::guard('vendor')->user()->id)->where('order_status', 'cancelled_by_vendor');
        $total_refunded          = Orders::where('vendor_id', Auth::guard('vendor')->user()->id)->where('order_status', 'cancelled_by_customer_during_prepare');
        $order_sum               =\App\Models\OrderCommision::where('vendor_id', Auth::guard('vendor')->user()->id)->select(\DB::raw('IFNULL(gross_revenue,0) as gross_revenue'));
        $cancelled_orders        =\App\Models\OrderCommision::where(['vendor_id' => Auth::guard('vendor')->user()->id, 'cancel_by_vendor' => 1])->select(\DB::raw('IFNULL(vendor_cancel_charge,0) as vendor_cancel_charge'));
        $total_refundAmount        =\App\Models\OrderCommision::where(['vendor_id' => Auth::guard('vendor')->user()->id])->select(\DB::raw('IFNULL(additions,0) as additions'));
        //->whereBetween('order_commisions.order_date', [$start_date, $end_date])->sum('gross_revenue');
        //$total_order        = Orders::where('vendor_id', Auth::guard('vendor')->user()->id)->where('order_status','!=', 'pending');
        $graph_data         = Orders::where('vendor_id', Auth::guard('vendor')->user()->id)->where('order_status','completed');
        if ($request->filter == 1 || $request->filter == '') {
            $text  = "Today";
            
            $total_orders = $total_orders->whereDate('created_at','=',mysql_date());
            $total_pending = $total_pending->whereDate('created_at','=',mysql_date());
            
            $total_dispatched = $total_dispatched->whereDate('created_at','=',mysql_date());
            $total_ready_to_dispatch = $total_ready_to_dispatch->whereDate('created_at','=',mysql_date());
            $total_prepairing = $total_prepairing->whereDate('created_at','=',mysql_date());
            $total_completed = $total_completed->whereDate('created_at','=',mysql_date());
            $total_rejected = $total_rejected->whereDate('created_at','=',mysql_date());
            $total_refunded = $total_refunded->whereDate('created_at','=',mysql_date());
            //$total_order = $total_order->whereDate('created_at','=',mysql_date());
            $graph_data = $graph_data->whereDate('created_at','=',mysql_date());
            $order_sum = $order_sum->whereDate('order_date','=',mysql_date());
            $cancelled_orders = $cancelled_orders->whereDate('order_date','=',mysql_date());
            $total_refundAmount = $total_refundAmount->whereDate('order_date','=',mysql_date());
            

        } else if ($request->filter == 2) {
            $start  = date('Y-m-d 00:00:00', strtotime('1 weeks ago'));
            $finish = date('Y-m-d H:i:s');
            $text   = front_end_short_date_time($start) . " - " . front_end_short_date_time($finish);
            $total_orders = $total_orders->whereBetween('created_at',[$start,$finish]);
            $total_pending = $total_pending->whereBetween('created_at',[$start,$finish]);
            $total_dispatched = $total_dispatched->whereBetween('created_at',[$start,$finish]);
            $total_ready_to_dispatch = $total_ready_to_dispatch->whereBetween('created_at',[$start,$finish]);
            $total_prepairing = $total_prepairing->whereBetween('created_at',[$start,$finish]);
            $total_completed = $total_completed->whereBetween('created_at',[$start,$finish]);
            $total_rejected = $total_rejected->whereBetween('created_at',[$start,$finish]);
            $total_refunded = $total_refunded->whereBetween('created_at',[$start,$finish]);
            //$total_order = $total_order->whereBetween('created_at',[$start,$finish]);
            $graph_data = $graph_data->whereBetween('created_at',[$start,$finish]);
            $order_sum = $order_sum->whereBetween('order_date',[$start,$finish]);
            $cancelled_orders = $cancelled_orders->whereBetween('order_date',[$start,$finish]);
            $total_refundAmount = $total_refundAmount->whereBetween('order_date',[$start,$finish]);
        }
        if ($request->filter == 3) {
            $start  = date("Y-m-01", time());
            $finish = date('Y-m-d H:i:s');
            $text   = front_end_short_date_time($start) . " - " . front_end_short_date_time($finish);
            
            $total_orders = $total_orders->whereBetween('created_at',[$start,$finish]);
            $total_pending = $total_pending->whereBetween('created_at',[$start,$finish]);
            $total_dispatched = $total_dispatched->whereBetween('created_at',[$start,$finish]);
            $total_ready_to_dispatch = $total_ready_to_dispatch->whereBetween('created_at',[$start,$finish]);
            $total_prepairing = $total_prepairing->whereBetween('created_at',[$start,$finish]);
            $total_completed = $total_completed->whereBetween('created_at',[$start,$finish]);
            $total_rejected = $total_rejected->whereBetween('created_at',[$start,$finish]);
            $total_refunded = $total_refunded->whereBetween('created_at',[$start,$finish]);
            //$total_order = $total_order->whereBetween('created_at',[$start,$finish]);
            $graph_data = $graph_data->whereBetween('created_at',[$start,$finish]);
            $order_sum = $order_sum->whereBetween('order_date',[$start,$finish]);
            $cancelled_orders = $cancelled_orders->whereBetween('order_date',[$start,$finish]);
            $total_refundAmount = $total_refundAmount->whereBetween('order_date',[$start,$finish]);

        }
        $total_orders               = $total_orders->count();
        $total_pending              = $total_pending->count();
        $total_dispatched           = $total_dispatched->count();
        $total_ready_to_dispatch    = $total_ready_to_dispatch->count();
        $total_prepairing           = $total_prepairing->count();
        $total_completed            = $total_completed->count();
        $total_rejected             = $total_rejected->count();
        $total_refunded             = $total_refunded->count();
        $order_sum                  = $order_sum->first()->gross_revenue;
        $cancelled_orders           = $cancelled_orders->first()->vendor_cancel_charge;
        $total_refundAmount         = $total_refundAmount->first()->additions;
        $paymentSetting = \App\Models\Paymentsetting::first();
        $admin_amount = ($order_sum * Auth::guard('vendor')->user()->commission) / 100;
        $tax_amount = ($admin_amount * 18) / 100;
        $convenience_amount = ($order_sum * $paymentSetting->convenience_fee) / 100;
        $deductions = $admin_amount + $tax_amount + $convenience_amount  + $cancelled_orders;
        $net_receivables = round($order_sum - ($admin_amount + $tax_amount + $convenience_amount  + $cancelled_orders),2);
        //$total_order                = $total_order->count();
        $total_refund               = 0;

//        dd(\DB::getQueryLog());
        $graph_data = $graph_data->select(\DB::raw("created_at, COUNT(`created_at`) as order_count,SUM(`net_amount`) as total_net_amount, DATE_FORMAT(`created_at` , '%b-%d') AS Month_Group"))->groupBy('Month_Group')->get();
        
            
        $top_rated_products = Product_master::where('userId', Auth::guard('vendor')->user()->id)->where('product_rating','>',0)->orderBy('product_rating', 'desc')->limit(4)->get();

        return view('vendor.restaurant.dashboard', compact('product', 'total_completed', 'total_prepairing', 'total_dispatched', 'total_ready_to_dispatch', 'total_pending', 'total_orders', 'text', 'total_rejected', 'total_refund', 'graph_data', 'top_rated_products','net_receivables','total_refunded','total_refundAmount'));
    }
}
