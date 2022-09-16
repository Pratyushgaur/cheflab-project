<?php

namespace App\Http\Controllers\vendor\restaurant;

use App\Events\IsAllSettingDoneEvent;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use App\Models\VendorMenus;
use App\Models\Order_time;
use App\Models\VendorOrderTime;
use App\Models\vendors;
use App\Rules\VendorOrderTimeRule;
use Illuminate\Support\Str;
use DataTables;
use Config;
use Illuminate\Support\Facades\Auth;

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

        return view('vendor.restaurant.globleseting.require_ordertime', compact('hideSidebar', 'VendorOrderTime'));
    }

    public function order_time()
    {
        $VendorOrderTime = [];
        $order_time = VendorOrderTime::where('vendor_id', Auth::guard('vendor')->user()->id)->get();
        foreach ($order_time as $v)
            $VendorOrderTime[$v->day_no] = $v->toArray();
        // dd($VendorOrderTime);
        return view('vendor.restaurant.globleseting.ordertime', compact('VendorOrderTime'));
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

        if ($request->routeIs('restaurant.ordertime.first_store')) //if first time save setting
            return redirect()->route('restaurant.globleseting.ordertime')->with('success', 'Settings update Successfully');
        else
            return redirect()->route('restaurant.globleseting.ordertime')->with('success', 'Settings update Successfully');
    }



    // public function first_store(Request $request)
    // {

    //     $request->validate([
    //         'start_time.*' => 'nullable|date_format:H:i',
    //         'end_time.*' => 'nullable|date_format:H:i',
    //         'available.*' =>  ['nullable', 'between:0,1', new VendorOrderTimeRule($request)],
    //         'lat' => ['required', 'regex:/^[-]?(([0-8]?[0-9])\.(\d+))|(90(\.0+)?)$/'],
    //         'long' => ['required', 'regex:/^[-]?((((1[0-7][0-9])|([0-9]?[0-9]))\.(\d+))|180(\.0+)?)$/'],
    //     ]);

    //     foreach ($request->start_time as $key => $val) {
    //         if ($request->available[$key] == 1)
    //             $data[] = [
    //                 'vendor_id' => Auth::guard('vendor')->user()->id,
    //                 'day_no' => $key,
    //                 'start_time' => $request->start_time[$key],
    //                 'end_time' => $request->end_time[$key],
    //                 'available' => $request->available[$key],
    //             ];
    //         else
    //             $data[] = [
    //                 'vendor_id' => Auth::guard('vendor')->user()->id,
    //                 'day_no' => $key,
    //                 'start_time' => null,
    //                 'end_time' => null,
    //                 'available' => 0,
    //             ];
    //     }

    //     // Order_time::upsert($data,['vendor_id','day_no'],['start_time','end_time','available']);
    //     $exist = Order_time::where('vendor_id', Auth::guard('vendor')->user()->id)->exists();

    //     if ($exist)
    //         foreach ($request->start_time as $key => $val)
    //             Order_time::where('vendor_id', Auth::guard('vendor')->user()->id)
    //                 ->where('day_no', $key)
    //                 ->update($data[$key]);
    //     else {
    //         Order_time::insert($data);
    //     }
    //     vendors::where('id', Auth::guard('vendor')->user()->id)->update([
    //         'lat' => $request->lat,
    //         'long' => $request->long
    //     ]);
    //     event(new IsAllSettingDoneEvent());
    //     return redirect()->route('restaurant.globleseting.ordertime')->with('success', 'Settings update Successfully');
    // }

    public function vendor_location()
    {
        $Vendor = [];
        $Vendor = vendors::where('id', Auth::guard('vendor')->user()->id)->first();

        return view('vendor.restaurant.globleseting.vendor_location', compact('Vendor'));
    }

    public function first_vendor_location()
    {
        $hideSidebar = true;
        $Vendor = [];
        $Vendor = vendors::where('id', Auth::guard('vendor')->user()->id)->first();

        return view('vendor.restaurant.globleseting.require_location', compact('Vendor', 'hideSidebar'));
    }

    public function save_vendor_location(Request $request)
    {
        // dd("hjhh");
        $request->validate([
            'lat' => ['required', 'regex:/^[-]?(([0-8]?[0-9])\.(\d+))|(90(\.0+)?)$/'],
            'long' => ['required', 'regex:/^[-]?((((1[0-7][0-9])|([0-9]?[0-9]))\.(\d+))|180(\.0+)?)$/'],
        ]);

        vendors::where('id', Auth::guard('vendor')->user()->id)->update([
            'lat' => $request->lat,
            'long' => $request->long
        ]);
        event(new IsAllSettingDoneEvent());
        if ($request->routeIs('restaurant.globleseting.frist_save_vendor_location')) //if first time save setting
            return redirect()->route('restaurant.dashboard')->with('success', 'Settings update Successfully');
        else
            return redirect()->back()->with('success', 'Settings update Successfully');
    }
    public function first_vendor_Logo()
    {
        $hideSidebar = true;
        $Vendor = [];
        $Vendor = vendors::where('id', Auth::guard('vendor')->user()->id)->first();

        return view('vendor.restaurant.globleseting.require_logo_banner', compact('Vendor', 'hideSidebar'));
    }
    public function save_vendor_Logo(Request $request){
        $this->validate($request, [
            'logo' => 'required',
            'banner' => 'required'
        ]);
        //dd($request->all());
        // $ex =   explode(';',$request->logo);
        // $extainsion =  explode('/',$ex[0]);
        
        // //
        // $image = $request->input('logo');  // your base64 encoded
        // $image = str_replace('data:image/png;base64,', '', $image);
        // $image = str_replace(' ', '+', $image);
        // $imageName = 'logo-'.Str::random(10).'.'.$extainsion[1];
        //  $path = public_path('vendors').'/' . $imageName;
        //  //\File::put(public_path('vendors') . $imageName, base64_decode($image));
        //  //\Image::make(file_get_contents($request->logo))->save($path);     
        //  $request->logo->move(public_path('vendor'),$filename);
        // logo generate

        $img = $request->logo;
        $folderPath = "vendors/"; //path location
        
        $image_parts = explode(";base64,", $img);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];
        $image_base64 = base64_decode($image_parts[1]);
        $name = 'logo-'.Str::random(10).uniqid();
        $file = $folderPath .$name. '.'.$image_type;
        file_put_contents($file, $image_base64);
        vendors::where('id', Auth::guard('vendor')->user()->id)->update(['image'=>$name.'.'.$image_type]);

        if (!empty($request->banner)){
            $json = [];
            foreach($request->banner as $k =>$img){
                $folderPath = "vendor-banner/"; //path location
                
                $image_parts = explode(";base64,", $img);
                $image_type_aux = explode("image/", $image_parts[0]);
                $image_type = $image_type_aux[1];
                $image_base64 = base64_decode($image_parts[1]);
                $name = 'banner-'.Str::random(10).uniqid();
                $file = $folderPath .$name. '.'.$image_type;
                file_put_contents($file, $image_base64);
                $json[] = $name.'.'.$image_type;
            }
            vendors::where('id', Auth::guard('vendor')->user()->id)->update(['banner_image'=>json_encode($json)]);
        }

        event(new IsAllSettingDoneEvent());
        return redirect()->route('restaurant.dashboard')->with('success', 'Settings update Successfully');


        
      
        
    }
}
