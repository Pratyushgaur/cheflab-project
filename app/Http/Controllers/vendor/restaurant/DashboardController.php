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
        updateDriverLatLngFromFcm();
        $product = Product_master::where('userId', '=', Auth::guard('vendor')->user()->id);
        $product = $product->select('products.product_name', 'products.id as product_id', 'product_image', 'product_price');
        $product = $product->addSelect(\DB::raw('(SELECT IFNULL(COUNT(id),0) as total FROM order_products WHERE  order_products.product_id =  products.id ) AS orderTotal'));
        $product = $product->orderBy('product_rating', 'DESC')->limit(4)->get();
        $text    = "Till Now";

        //order count
        \DB::enableQueryLog();
        $order_obj = Orders::where('vendor_id', Auth::guard('vendor')->user()->id);
        $where = [['vendor_id', '=', Auth::guard('vendor')->user()->id]];

        if ($request->filter == 1) {
            $text  = "Today";
            $where = [
                ['created_at', '=', mysql_date()]
            ];
        } else if ($request->filter == 2) {
            $start  = date('Y-m-d 00:00:00', strtotime('1 weeks ago'));
            $finish = date('Y-m-d H:i:s');
            $text   = front_end_short_date_time($start) . " - " . front_end_short_date_time($finish);
            $where  = [
                ['created_at', '=>', $start],
                ['created_at', '<=', $finish]
            ];
        }
        if ($request->filter == 3) {
            $start  = date("Y-m-01", time());
            $finish = date('Y-m-d H:i:s');
            $text   = front_end_short_date_time($start) . " - " . front_end_short_date_time($finish);
            $where  = [
                ['created_at', '>', $start],
                ['created_at', '<=', $finish]
            ];
        }

        $total_order             = Orders::where('vendor_id', Auth::guard('vendor')->user()->id)->where($where)->count();
        $total_completed         = Orders::where('vendor_id', Auth::guard('vendor')->user()->id)->where($where)->where('order_status', 'completed')->count();
        $total_prepairing        = Orders::where('vendor_id', Auth::guard('vendor')->user()->id)->where($where)->where('order_status', 'preparing')->count();
        $total_ready_to_dispatch = Orders::where('vendor_id', Auth::guard('vendor')->user()->id)->where($where)->where('order_status', 'ready_to_dispatch')->count();
        $total_dispatched        = Orders::where('vendor_id', Auth::guard('vendor')->user()->id)->where($where)->where('order_status', 'dispatched')->count();
        $total_confirmed         = Orders::where('vendor_id', Auth::guard('vendor')->user()->id)->where($where)->whereNotIn('order_status', ['pending',
                                                                                                                                             'cancelled_by_customer_before_confirmed',
                                                                                                                                             'cancelled_by_customer_after_confirmed',
                                                                                                                                             'cancelled_by_customer_during_prepare',
                                                                                                                                             'cancelled_by_vendor'])->count();
        $total_refund            = Orders::where('vendor_id', Auth::guard('vendor')->user()->id)->where($where)->where('refund', '2')->count();

//        dd(\DB::getQueryLog());
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
