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
        $total_confirmed = Orders::where('vendor_id', Auth::guard('vendor')->user()->id)->whereNotIn('order_status', ['pending','cancelled_by_customer_before_confirmed','cancelled_by_customer_after_confirmed','cancelled_by_customer_during_prepare','cancelled_by_vendor']);
        $total_pending = Orders::where('vendor_id', Auth::guard('vendor')->user()->id)->where('order_status', 'confirmed');
        $total_dispatched        = Orders::where('vendor_id', Auth::guard('vendor')->user()->id)->where('order_status', 'dispatched');
        $total_ready_to_dispatch        = Orders::where('vendor_id', Auth::guard('vendor')->user()->id)->where('order_status', 'ready_to_dispatch');
        $total_prepairing        = Orders::where('vendor_id', Auth::guard('vendor')->user()->id)->where('order_status', 'preparing');
        $total_completed        = Orders::where('vendor_id', Auth::guard('vendor')->user()->id)->where('order_status', 'completed');
        $total_rejected        = Orders::where('vendor_id', Auth::guard('vendor')->user()->id)->where('order_status', 'cancelled_by_vendor');
        
        $total_order        = Orders::where('vendor_id', Auth::guard('vendor')->user()->id)->where('order_status','!=', 'pending');
        $graph_data         = Orders::where('vendor_id', Auth::guard('vendor')->user()->id)->where('order_status','completed');
        if ($request->filter == 1 || $request->filter == '') {
            $text  = "Today";
            
            $total_confirmed = $total_confirmed->whereDate('created_at','=',mysql_date());
            $total_pending = $total_pending->whereDate('created_at','=',mysql_date());
            
            $total_dispatched = $total_dispatched->whereDate('created_at','=',mysql_date());
            $total_ready_to_dispatch = $total_ready_to_dispatch->whereDate('created_at','=',mysql_date());
            $total_prepairing = $total_prepairing->whereDate('created_at','=',mysql_date());
            $total_completed = $total_completed->whereDate('created_at','=',mysql_date());
            $total_rejected = $total_rejected->whereDate('created_at','=',mysql_date());
            $total_order = $total_order->whereDate('created_at','=',mysql_date());
            $graph_data = $graph_data->whereDate('created_at','=',mysql_date());

        } else if ($request->filter == 2) {
            $start  = date('Y-m-d 00:00:00', strtotime('1 weeks ago'));
            $finish = date('Y-m-d H:i:s');
            $text   = front_end_short_date_time($start) . " - " . front_end_short_date_time($finish);
            $total_confirmed = $total_confirmed->whereBetween('created_at',[$start,$finish]);
            $total_pending = $total_pending->whereBetween('created_at',[$start,$finish]);
            $total_dispatched = $total_dispatched->whereBetween('created_at',[$start,$finish]);
            $total_ready_to_dispatch = $total_ready_to_dispatch->whereBetween('created_at',[$start,$finish]);
            $total_prepairing = $total_prepairing->whereBetween('created_at',[$start,$finish]);
            $total_completed = $total_completed->whereBetween('created_at',[$start,$finish]);
            $total_rejected = $total_rejected->whereBetween('created_at',[$start,$finish]);
            $total_order = $total_order->whereBetween('created_at',[$start,$finish]);
            $graph_data = $graph_data->whereBetween('created_at',[$start,$finish]);
        }
        if ($request->filter == 3) {
            $start  = date("Y-m-01", time());
            $finish = date('Y-m-d H:i:s');
            $text   = front_end_short_date_time($start) . " - " . front_end_short_date_time($finish);
            
            $total_confirmed = $total_confirmed->whereBetween('created_at',[$start,$finish]);
            $total_pending = $total_pending->whereBetween('created_at',[$start,$finish]);
            $total_dispatched = $total_dispatched->whereBetween('created_at',[$start,$finish]);
            $total_ready_to_dispatch = $total_ready_to_dispatch->whereBetween('created_at',[$start,$finish]);
            $total_prepairing = $total_prepairing->whereBetween('created_at',[$start,$finish]);
            $total_completed = $total_completed->whereBetween('created_at',[$start,$finish]);
            $total_rejected = $total_rejected->whereBetween('created_at',[$start,$finish]);
            $total_order = $total_order->whereBetween('created_at',[$start,$finish]);
            $graph_data = $graph_data->whereBetween('created_at',[$start,$finish]);

        }
        $total_confirmed            = $total_confirmed->count();
        $total_pending              = $total_pending->count();
        $total_dispatched           = $total_dispatched->count();
        $total_ready_to_dispatch    = $total_ready_to_dispatch->count();
        $total_prepairing           = $total_prepairing->count();
        $total_completed            = $total_completed->count();
        $total_rejected             = $total_rejected->count();
        $total_order                = $total_order->count();
        $total_refund               = 0;

//        dd(\DB::getQueryLog());
        $graph_data = $graph_data->select(\DB::raw("created_at, COUNT(`created_at`) as order_count,SUM(`net_amount`) as total_net_amount, DATE_FORMAT(`created_at` , '%b-%d') AS Month_Group"))->groupBy('Month_Group')->get();
        
            
        $top_rated_products = Product_master::where('userId', Auth::guard('vendor')->user()->id)->where('product_rating','>',0)->orderBy('product_rating', 'desc')->limit(4)->get();

        return view('vendor.restaurant.dashboard', compact('product', 'total_order', 'total_completed', 'total_prepairing', 'total_dispatched', 'total_ready_to_dispatch', 'total_pending', 'total_confirmed', 'text', 'total_rejected', 'total_refund', 'graph_data', 'top_rated_products'));
    }
}
