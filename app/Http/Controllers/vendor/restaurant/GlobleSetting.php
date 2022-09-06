<?php

namespace App\Http\Controllers\vendor\restaurant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use App\Models\VendorMenus;
use App\Models\Order_time;
use DataTables;
use Config;


class GlobleSetting extends Controller
{
    public function index()
    {
        return view('vendor.restaurant.globleseting.tabs');
    }
    public function order_time(){
        return view('vendor.restaurant.globleseting.ordertime');
    }
    public function store(Request $request)
    {
        
        $VendorTime = new Order_time;
        $VendorTime->day_no = $request->day_no;
        $VendorTime->start_time = $request->start_time;
        $VendorTime->end_time = $request->end_time;
        $VendorTime->available = $request->available;
        $VendorTime->vendor_id = \Auth::guard('vendor')->user()->id;
        $VendorTime->save();
        return redirect()->route('restaurant.menu.list')->with('success', 'Menu Created Successfully');
        
    }
}