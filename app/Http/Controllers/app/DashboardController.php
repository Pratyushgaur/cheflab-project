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
use App\Models\Orders;
class DashboardController extends Controller
{
    public function index(Request $request)
    {   
        
        
        $orders = Orders::where('vendor_id', Auth::guard('vendor')->user()->id)->whereNotIn('order_status', ['pending','cancelled_by_customer_before_confirmed'])->orderBy('id','desc')->skip(0)->take(10)->get();
        $users = [];
        return view('vendor.vendor_app.dashboard',compact('orders','users'));
    }
}
