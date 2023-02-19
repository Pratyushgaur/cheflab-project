<?php

namespace App\Http\Controllers\admin;

use App\Models\MangaoStaticUseradmin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vendors;
use App\Models\Deliver_boy;
use App\Models\Orders;
use Illuminate\Support\Facades\Gate;
use App\Models\Notification;
use Auth;

class Dashboard extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // echo $password = Hash::make('123456');
        
        // $response = Gate::inspect('isSuperAdmin');
        
        // Gate::authorize('isSuperAdmin');
 
        // if (Gate::allows('isSuperAdmin')) {

        //    echo "you are admin";

        // } else {

        //     echo "you are not admin";

        // }

        // return $response;
        // if (Gate::denies('isSuperAdmin')) {
        //         abort(403);
        //     }

        // die();
        
        //
        $total_app_user = \App\Models\User::count();
        $total_delivery_boy = \App\Models\Deliver_boy::count();
        $total_restaurant = \App\Models\Vendors::where('vendor_type','restaurant')->count();
        $total_chef = \App\Models\Vendors::where('vendor_type','chef')->count();
        $top_deliveryBoy = \App\Models\Deliver_boy::where('ratings','>','0')->orderBy('ratings','DESC')->select('name','ratings','image','id')->limit(8)->get();
        $top_vendors = \App\Models\Vendors::where('vendor_ratings','>','0')->where('vendor_type','restaurant')->orderBy('vendor_ratings','DESC')->select('name','vendor_ratings','image','id')->limit(8)->get();
        $active_res = \App\Models\Vendors::where('status','=','1')->where('vendor_type','restaurant')->count();
        $active_online_res = \App\Models\Vendors::where('status','=','1')->where('is_online','1')->where('vendor_type','restaurant')->count();
        $active_rider = \App\Models\Deliver_boy::where('status','=','1')->count();
        $active_online_rider = \App\Models\Deliver_boy::where('status','=','1')->where('is_online','1')->count();
        $letestOrders = \App\Models\Order::where('order_status','!=','pending')->join('vendors','orders.vendor_id','=','vendors.id')->orderBy('orders.id','desc')->limit(10)->select('orders.id','order_id','order_status','orders.created_at','vendors.name')->get();
        
        return view('admin.dashbord.dash',compact('total_app_user','total_delivery_boy','total_restaurant','total_chef','top_deliveryBoy','top_vendors','active_res','active_online_res','active_rider','active_online_rider','letestOrders'));
    }
}
