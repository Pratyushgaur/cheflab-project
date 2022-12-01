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

        $product = Product_master::where('userId', '=', Auth::guard('vendor')->user()->id);
        $product = $product->select('products.product_name', 'products.id as product_id', 'product_image', 'product_price');
        $product = $product->addSelect(\DB::raw('(SELECT IFNULL(COUNT(id),0) as total FROM order_products WHERE  order_products.product_id =  products.id ) AS orderTotal'));
        $product = $product->orderBy('product_rating', 'DESC')->limit(4)->get();
        $text    = "Till Now";
        //order count
        $order_obj = Orders::where('vendor_id', Auth::guard('vendor')->user()->id);
        if ($request->filter == 1) {
            $text = "Today";
            $order_obj->where('created_at', mysql_date());
        } else if ($request->filter == 2) {
            $start  = date('Y-m-d 00:00:00', strtotime('1 weeks ago'));
            $finish = date('Y-m-d H:i:s');
            $text   = front_end_short_date_time($start) . " - " . front_end_short_date_time($finish);

            $order_obj->where('created_at', '>', $start);
            $order_obj->where('created_at', '<=', $finish);
        }
        if ($request->filter == 3) {
            $start  = date("Y-m-01", time());
            $finish = date('Y-m-d H:i:s');
            $text   = front_end_short_date_time($start) . " - " . front_end_short_date_time($finish);

            $order_obj->where('created_at', '>', $start);
            $order_obj->where('created_at', '<=', $finish);
        }

        $order_obj6 = $order_obj5 = $order_obj4 = $order_obj3 = $order_obj2 = $order_obj1 = $order_obj;

        $total_order = $order_obj->count();
        unset($order_obj);
        $total_completed = $order_obj1->where('order_status', 'completed')->count();
        unset($order_obj1);
        $total_prepairing = $order_obj2->where('order_status', 'preparing')->count();
        unset($order_obj2);
        $total_ready_to_dispatch = $order_obj3->where('order_status', 'ready_to_dispatch')->count();
        unset($order_obj3);
        $total_dispatched = $order_obj4->where('order_status', 'ready_to_dispatch')->count();
        unset($order_obj4);
        $total_confirmed = $order_obj5->whereNotIn('order_status', ['pending', 'cancelled_by_customer', 'cancelled_by_vendor'])->count();
        unset($order_obj5);
        $total_refund = $order_obj6->whereNotIn('order_status', ['pending', 'cancelled_by_customer', 'cancelled_by_vendor'])->count();
        unset($order_obj5);

        $graph_data = Orders::where('vendor_id', Auth::guard('vendor')->user()->id)
//            ->where('payment_status','paid')
            ->where('order_status', 'completed')
//            ->where('refund',0)
            ->addSelect(\DB::raw("created_at, COUNT(`created_at`) as order_count,SUM(`net_amount`) as total_net_amount, DATE_FORMAT(`created_at` , '%m') AS Month_Group"))
            ->groupBy('Month_Group')
            ->get();

        $top_rated_products = Product_master::where('userId', Auth::guard('vendor')->user()->id)->orderBy('product_rating', 'desc')->limit(4)->get();

        return view('vendor.restaurant.dashboard', compact('product', 'total_order', 'total_completed', 'total_prepairing', 'total_dispatched', 'total_ready_to_dispatch', 'total_confirmed', 'text', 'total_refund', 'graph_data', 'top_rated_products'));
    }
}
