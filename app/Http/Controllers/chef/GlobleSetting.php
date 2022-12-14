<?php

namespace App\Http\Controllers\vendor\chef;

use App\Events\IsAllSettingDoneEvent;
use App\Http\Controllers\Controller;
use App\Models\BankDetail;
use App\Models\Order_time;
use App\Models\VendorOrderTime;
use App\Models\vendors;
use App\Rules\VendorOrderTimeRule;
use Config;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class GlobleSetting extends Controller
{
    public function index()
    {
        return view('vendor.chef.globleseting.tabs');
    }

    public function requireOrderTime()
    {
        $VendorOrderTime = [];
        $hideSidebar     = true;
        $order_time      = VendorOrderTime::where('vendor_id', Auth::guard('vendor')->user()->id)->get();
        foreach ($order_time as $v) $VendorOrderTime[$v->day_no] = $v->toArray();

        return view('vendor.chef.globleseting.require_ordertime', compact('hideSidebar', 'VendorOrderTime'));
    }

    public function order_time()
    {
        $VendorOrderTime = [];
        $order_time      = VendorOrderTime::select(DB::raw('DATE_FORMAT(start_time, "%H:%i") as start_time ,DATE_FORMAT(end_time, "%H:%i") as end_time,day_no,vendor_id'))->where('vendor_id', Auth::guard('vendor')->user()->id)->get();
        foreach ($order_time as $v) $VendorOrderTime[$v->day_no] = $v->toArray();
        // dd($VendorOrderTime);
        return view('vendor.chef.globleseting.ordertime', compact('VendorOrderTime'));
    }

    public function store(Request $request)
    {

        // dd($request->routeIs('chef.ordertime.first_store'));
        // dd($request->all());
        $request->validate(['start_time.*' => 'nullable|date_format:H:i', 'end_time.*' => 'nullable|date_format:H:i', 'available.*' => ['nullable', 'between:0,1', new VendorOrderTimeRule($request)],]);

        foreach ($request->start_time as $key => $val) {
            if ($request->available[$key] == 1) $data[] = ['vendor_id' => Auth::guard('vendor')->user()->id, 'day_no' => $key, 'start_time' => date('H:i:s', strtotime($request->start_time[$key])), 'end_time' => date('H:i:s', strtotime($request->end_time[$key])), 'available' => $request->available[$key],]; else
                $data[] = ['vendor_id' => Auth::guard('vendor')->user()->id, 'day_no' => $key, 'start_time' => null, 'end_time' => null, 'available' => 0,];
        }

        // Order_time::upsert($data,['vendor_id','day_no'],['start_time','end_time','available']);
        $exist = Order_time::where('vendor_id', Auth::guard('vendor')->user()->id)->exists();

        if ($exist) foreach ($request->start_time as $key => $val) Order_time::where('vendor_id', Auth::guard('vendor')->user()->id)->where('day_no', $key)->update($data[$key]); else {
            Order_time::insert($data);
            event(new IsAllSettingDoneEvent());
        }
        //dd($request->routeIs('chef.ordertime.first_store'));
        if ($request->routeIs('chef.ordertime.first_store')) //if first time save setting
            return redirect()->route('chef.dashboard')->with('poup_success', 'Your chef timing update Successfully'); else return redirect()->route('chef.globleseting.ordertime')->with('success', 'Settings update Successfully');
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
    //     return redirect()->route('chef.globleseting.ordertime')->with('success', 'Settings update Successfully');
    // }

    public function vendor_location()
    {
        $Vendor = [];
        $Vendor = vendors::where('id', Auth::guard('vendor')->user()->id)->first();

        return view('vendor.chef.globleseting.vendor_location', compact('Vendor'));
    }

    public function first_vendor_location()
    {
        $hideSidebar = true;
        $Vendor      = [];
        $Vendor      = vendors::where('id', Auth::guard('vendor')->user()->id)->first();

        return view('vendor.chef.globleseting.require_location', compact('Vendor', 'hideSidebar'));
    }

    public function save_vendor_location(Request $request)
    {
        // dd("hjhh");
        $request->validate(['lat' => ['required', 'regex:/^[-]?(([0-8]?[0-9])\.(\d+))|(90(\.0+)?)$/'], 'long' => ['required', 'regex:/^[-]?((((1[0-7][0-9])|([0-9]?[0-9]))\.(\d+))|180(\.0+)?)$/'],]);

        vendors::where('id', Auth::guard('vendor')->user()->id)->update(['lat' => $request->lat, 'long' => $request->long]);
        event(new IsAllSettingDoneEvent());
        if ($request->routeIs('chef.globleseting.frist_save_vendor_location')) //if first time save setting
            return redirect()->route('chef.dashboard')->with('poup_success', 'Settings update Successfully'); else return redirect()->back()->with('success', 'Settings update Successfully');
    }

    public function first_vendor_Logo()
    {
        $hideSidebar = true;
        $Vendor      = [];
        $Vendor      = vendors::where('id', Auth::guard('vendor')->user()->id)->first();

        return view('vendor.chef.globleseting.require_logo_banner', compact('Vendor', 'hideSidebar'));
    }

    public function save_vendor_Logo(Request $request)
    {
        $this->validate($request, ['logo' => 'required', 'banner' => 'required']);
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

        $img        = $request->logo;
        $folderPath = "vendors/"; //path location

        $image_parts    = explode(";base64,", $img);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type     = $image_type_aux[1];
        $image_base64   = base64_decode($image_parts[1]);
        $name           = 'logo-' . Str::random(10) . uniqid();
        $file           = $folderPath . $name . '.' . $image_type;
        file_put_contents($file, $image_base64);
        vendors::where('id', Auth::guard('vendor')->user()->id)->update(['image' => $name . '.' . $image_type]);

        if (!empty($request->banner)) {
            $json = [];
            foreach ($request->banner as $k => $img) {
                $folderPath = "vendor-banner/"; //path location

                $image_parts    = explode(";base64,", $img);
                $image_type_aux = explode("image/", $image_parts[0]);
                $image_type     = $image_type_aux[1];
                $image_base64   = base64_decode($image_parts[1]);
                $name           = 'banner-' . Str::random(10) . uniqid();
                $file           = $folderPath . $name . '.' . $image_type;
                file_put_contents($file, $image_base64);
                $json[] = $name . '.' . $image_type;
            }
            vendors::where('id', Auth::guard('vendor')->user()->id)->update(['banner_image' => json_encode($json)]);
        }

        event(new IsAllSettingDoneEvent());
        return redirect()->route('chef.dashboard')->with('poup_success', 'Settings update Successfully');
    }

    public function first_bank_details()
    {
        $hideSidebar = true;
        $bankDetail  = BankDetail::where('vendor_id', Auth::guard('vendor')->user()->id)->first();

        return view('vendor.chef.globleseting.require_bankdetailes', compact('bankDetail', 'hideSidebar'));
    }

    public function bank_details()
    {
        $hideSidebar = false;
        $bankDetail  = BankDetail::where('vendor_id', Auth::guard('vendor')->user()->id)->first();

        return view('vendor.chef.globleseting.bankdetailes', compact('bankDetail', 'hideSidebar'));
    }

    public function save_bank_details(Request $request)
    {
        //        dd($request->all());
        //        dd($request->routeIs('chef.globleseting.save_bank_details'));
        /*        if ($request->routeIs('chef.globleseting.save_bank_details'))
                    $request->validate([
                        'holder_name' => 'required',
                        'ifsc' => 'required',
                        'bank_name' => 'required',
                        'account_no' => ['required', 'regex:/^\w{1,17}$/'],
                        'aadhar_number' => "required",
                        'fssai_lic_no' => "required",
                    ]);
                else
                    $request->validate([
                        'holder_name' => 'required',
                        'ifsc' => 'required',
                        'bank_name' => 'required',
        //            'cancel_check' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048|dimensions:min_width=100,min_height=100,max_width=1000,max_height=1000',
                        'cancel_check' => 'required',
                        'account_no' => ['required', 'regex:/^\w{1,17}$/'],
                        'aadhar_number' => "required",
                        'aadhar_card_image' => "required",
                        'pancard_number' => "required",
                        'pancard_image' => "required",
                        'fassi_image' => "required",
                        'fssai_lic_no' => "required",
                    ]);
        */
        $bank   = $request->all();
        $vendor = Vendors::find(Auth::guard('vendor')->user()->id);
        $bank   = BankDetail::where('vendor_id', Auth::guard('vendor')->user()->id)->first();
        if (!isset($bank->id)) {
            $bank            = new BankDetail();
            $bank->vendor_id = \Auth::guard('vendor')->user()->id;
        }

        if ($request->has('cancel_check') && $request->cancel_check != '') {
            $img        = $request->cancel_check;
            $folderPath = "vendor-documents/"; //path location

            $image_parts        = explode(";base64,", $img);
            $image_type_aux     = explode("image/", $image_parts[0]);
            $image_type         = $image_type_aux[1];
            $image_base64       = base64_decode($image_parts[1]);
            $name               = 'cancel_check-' . Str::random(10) . uniqid();
            $bank->cancel_check = $folderPath . $name . '.' . $image_type;
            file_put_contents($bank->cancel_check, $image_base64);
            $bank->cancel_check = $name . '.' . $image_type;;
            //            $filename = time() . '-cancel_check-' . rand(100, 999) . '.' . $request->cancel_check->extension();
            //            $request->cancel_check->move(public_path('vendor-documents'), $filename);
            //            $bank['cancel_check'] = $filename;
        }

        if ($request->has('fassi_image') && $request->fassi_image != '') {
            $img        = $request->fassi_image;
            $folderPath = "vendor-documents/"; //path location

            $image_parts           = explode(";base64,", $img);
            $image_type_aux        = explode("image/", $image_parts[0]);
            $image_type            = $image_type_aux[1];
            $image_base64          = base64_decode($image_parts[1]);
            $name                  = 'fassi_image-' . Str::random(10) . uniqid();
            $vendor->licence_image = $folderPath . $name . '.' . $image_type;
            file_put_contents($vendor->licence_image, $image_base64);
            $vendor->licence_image = $name . '.' . $image_type;;
            //            $filename = time() . '-cancel_check-' . rand(100, 999) . '.' . $request->cancel_check->extension();
            //            $request->cancel_check->move(public_path('vendor-documents'), $filename);
            //            $bank['cancel_check'] = $filename;
        }

        if ($request->has('pancard_image') && $request->pancard_image != '') {
            $img        = $request->pancard_image;
            $folderPath = "vendor-documents/"; //path location

            $image_parts           = explode(";base64,", $img);
            $image_type_aux        = explode("image/", $image_parts[0]);
            $image_type            = $image_type_aux[1];
            $image_base64          = base64_decode($image_parts[1]);
            $name                  = 'pancard_image-' . Str::random(10) . uniqid();
            $vendor->pancard_image = $folderPath . $name . '.' . $image_type;
            file_put_contents($vendor->pancard_image, $image_base64);
            $vendor->pancard_image = $name . '.' . $image_type;;
            //            $filename = time() . '-cancel_check-' . rand(100, 999) . '.' . $request->cancel_check->extension();
            //            $request->cancel_check->move(public_path('vendor-documents'), $filename);
            //            $bank['cancel_check'] = $filename;
        }
        if ($request->has('aadhar_card_image') && $request->aadhar_card_image != '') {
            $img        = $request->aadhar_card_image;
            $folderPath = "vendor-documents/"; //path location

            $image_parts               = explode(";base64,", $img);
            $image_type_aux            = explode("image/", $image_parts[0]);
            $image_type                = $image_type_aux[1];
            $image_base64              = base64_decode($image_parts[1]);
            $name                      = 'aadhar_card_image-' . Str::random(10) . uniqid();
            $vendor->aadhar_card_image = $folderPath . $name . '.' . $image_type;
            file_put_contents($vendor->aadhar_card_image, $image_base64);
            $vendor->aadhar_card_image = $name . '.' . $image_type;;
            //            $filename = time() . '-cancel_check-' . rand(100, 999) . '.' . $request->cancel_check->extension();
            //            $request->cancel_check->move(public_path('vendor-documents'), $filename);
            //            $bank['cancel_check'] = $filename;
        }

        $bank->holder_name = $request->holder_name;
        $bank->account_no  = $request->account_no;
        $bank->ifsc        = $request->ifsc;
        $bank->bank_name   = $request->bank_name;
        $bank->save();

        $vendor->aadhar_number  = $request->aadhar_number;
        $vendor->pancard_number = $request->pancard_number;
        $vendor->fssai_lic_no   = $request->fssai_lic_no;
        $vendor->save();
        return redirect()->route('chef.dashboard')->with('poup_success', 'Settings update Successfully');
    }
}
