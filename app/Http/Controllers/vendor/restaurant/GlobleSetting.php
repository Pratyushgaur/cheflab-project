<?php

namespace App\Http\Controllers\vendor\restaurant;

use App\Events\IsAllSettingDoneEvent;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use App\Models\VendorMenus;
use App\Models\Order_time;
use App\Models\VendorOrderTime;
use App\Rules\VendorOrderTimeRule;
use DataTables;
use Config;
use Illuminate\Support\Facades\Auth;

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

        // dd($request->all());
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
        else
        {    Order_time::insert($data);
            event(new IsAllSettingDoneEvent());
        }



        // $VendorTime = new Order_time;
        // $VendorTime->day_no = $request->day_no;
        // $VendorTime->start_time = $request->start_time;
        // $VendorTime->end_time = $request->end_time;
        // $VendorTime->available = $request->available;
        // $VendorTime->vendor_id = \Auth::guard('vendor')->user()->id;
        // $VendorTime->save();
        return redirect()->route('restaurant.globleseting.ordertime')->with('message', 'Settings update Successfully');
    }
}
