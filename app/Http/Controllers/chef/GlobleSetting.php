<?php

namespace App\Http\Controllers\chef;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use App\Models\VendorMenus;
use App\Models\VendorOrderTime;
use DataTables;
use Config;
use Auth;


class GlobleSetting extends Controller
{
    public function index()
    {
        return view('vendor.restaurant.globleseting.tabs');
    }
    public function requireOrderTime()
    {
        
        $VendorOrderTime = [];
        $hideSidebar = true;
        $order_time = VendorOrderTime::where('vendor_id', Auth::guard('vendor')->user()->id)->get();
        
        foreach ($order_time as $v)
            $VendorOrderTime[$v->day_no] = $v->toArray();

        return view('vendor.chef.globleseting.require_ordertime', compact('hideSidebar', 'VendorOrderTime'));
    }
    public function order_time(){
        return view('vendor.restaurant.globleseting.ordertime');
    }
    public function store(Request $request)
    {

        // dd($request->routeIs('restaurant.ordertime.first_store'));
        // dd(Auth::guard('vendor')->user()->id);
        $request->validate([
            'start_time.*' => 'nullable|date_format:H:i',
            'end_time.*' => 'nullable|date_format:H:i',
            'available.*' =>  ['nullable', 'between:0,1', new VendorOrderTimeRule($request)],
        ]);

        foreach ($request->start_time as $key => $val) {
            if ($request->available[$key] == 1)
                $data[] = [
                    'vendor_id' => Auth::guard('vendor')->user()->id,
                    'day_no' => $key,
                    'start_time' => $request->start_time[$key],
                    'end_time' => $request->end_time[$key],
                    'available' => $request->available[$key],
                ];
            else
                $data[] = [
                    'vendor_id' => Auth::guard('vendor')->user()->id,
                    'day_no' => $key,
                    'start_time' => null,
                    'end_time' => null,
                    'available' => 0,
                ];
        }

        // Order_time::upsert($data,['vendor_id','day_no'],['start_time','end_time','available']);
        $exist = Order_time::where('vendor_id', Auth::guard('vendor')->user()->id)->exists();

        if ($exist)
            foreach ($request->start_time as $key => $val)
                Order_time::where('vendor_id', Auth::guard('vendor')->user()->id)
                    ->where('day_no', $key)
                    ->update($data[$key]);
        else {
            Order_time::insert($data);
            event(new IsAllSettingDoneEvent());
        }

        if ($request->routeIs('chef.ordertime.first_store')) //if first time save setting
            return redirect()->route('restaurant.globleseting.ordertime')->with('success', 'Settings update Successfully');
        else
            return redirect()->route('restaurant.globleseting.ordertime')->with('success', 'Settings update Successfully');
    }
}