<?php

namespace App\Http\Controllers\chef;

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
      /*  $day_no = $request->day_no;
        $start_time = $request->start_time;
        $end_time= $request->end_time;
        $available= $request->available;
        $vendor_id = \Auth::guard('vendor')->user()->id;  
        for($i=0;$i<7;$i++){
           $post =  array("day_no"=>$day_no[$i],"start_time"=>$start_time[$i],"end_time"=>$end_time[$i],"available"=>$available[$i],"vendor_id"=>$vendor_id);
           Order_time::insert($post);
        }*/
       return redirect()->route('chef.globleseting.ordertime')->with('success', 'Time Created Successfully');
       
    }
}