<?php

namespace App\Http\Controllers\vendor\restaurant;

use App\Http\Controllers\Controller;
use App\Models\Catogory_master;
use App\Models\Cuisines;
use App\Models\Product_master;
use App\Models\UserVendorLike;
use App\Models\VendorOffline;
use App\Models\vendors;
use Carbon\Carbon;
use Illuminate\Http\Request;

class VendorController extends Controller
{
    public function set_offline(Request $request)
    {
        date_default_timezone_set(config('app.timezone'));
        // dd(strtotime( "next monday" ));
        if ($request->offline_till == 1) {
            $day[0]       = 'sunday';
            $day[1]       = 'monday';
            $day[2]       = 'Tuesday';
            $day[3]       = 'Wednesday';
            $day[4]       = 'Thursday';
            $day[5]       = 'friday';
            $day[6]       = 'saturday';
            $resum_date   = '';
            $timeSchedule = \App\Models\VendorOrderTime::where([
                'vendor_id' => Auth::guard('vendor')->user()->id,
                'available' => 1,
            ])->orderBy('day_no')->pluck('start_time', 'day_no')->toArray(); //Array key will be day_no
            if (!$timeSchedule)
                $msg = 'Now your Restaurant is offline.';
            else {
                if (array_key_last($timeSchedule) > Carbon::now()->dayOfWeek) {
                    for ($i = (Carbon::now()->dayOfWeek + 1); $i <= 6; $i++)
                        if (isset($timeSchedule[$i])) {
                            $resum_date = date('Y-m-d H:i:s', strtotime("next " . $day[$i]));
                            break;
                        }
                } else {
                    $day_no     = array_key_first($timeSchedule);
                    $resum_date = date('Y-m-d H:i:s', strtotime("next " . $day[$day_no]));
                }

                $vendor_offline                  = new VendorOffline();
                $vendor_offline->vendor_id       = Auth::guard('vendor')->user()->id;
                $vendor_offline->offline_time    = now();
                $vendor_offline->resume_date     = $resum_date;
                $vendor_offline->is_action_taken = 0;

                $vendor_offline->save();
                $msg = 'Now your Restaurant is offline. It will be automatically goes online  on ' . date('d M Y', strtotime($resum_date));
            }
        } else
            $msg = 'Now your Restaurant is offline.';
        vendors::where('id', Auth::guard('vendor')->user()->id)->update(['is_online' => 0]);
        $data = ['status' => 'success', 'msg' => $msg];
        return response()->json($data, 200);
        // return redirect()->back()->with('success', $msg);
    }

    /*public function set_online(Request $request)
    {
        vendors::where('id', Auth::guard('vendor')->user()->id)->update(['is_online' => 1]);
        return redirect()->back()->with('success', 'Now your Restauran is online.');
    }
    */
    public function restaurent_status(Request $request)
    {

        if ($request->restaurent_status == 'on') {
            vendors::where('id', Auth::guard('vendor')->user()->id)->update(['is_online' => 1]);
            $data = ['status' => 'success', 'msg' => 'Now your restaurant is online', 'rest_status' => 'on'];
        } else {
            vendors::where('id', Auth::guard('vendor')->user()->id)->update(['is_online' => 0]);
            $data = ['status' => 'success', 'msg' => 'Now your restaurant is offline,you will not able to get orders from mobile app.', 'rest_status' => 'on'];
        }
        return response()->json($data, 200);
    }

    public function restaurent_get_status(Request $request)
    {

        $v    = vendors::find(Auth::guard('vendor')->user()->id);
        $data = ['status' => 'success', 'rest_status' => $v->is_online];

        return response()->json($data, 200);
    }

    public function profile(Request $request)
    {
        $categories      = Catogory_master::where('is_active', '=', '1')->pluck('name', 'id');
        $cuisines        = Cuisines::where('is_active', '=', '1')->pluck('name', 'id');
        $resturant       = Vendors::find(\Auth::guard('vendor')->user()->id);
        $product_count   = Product_master::where('status', 1)->where('product_approve', 1)->groupBy('userId')->count();
        $like_user_count = UserVendorLike::where('vendor_id', \Auth::guard('vendor')->user()->id)->groupBy('vendor_id')->count();
        return view('vendor.restaurant.vendor.profile', compact('categories', 'cuisines', 'resturant', 'product_count', 'like_user_count'));
    }

    public function update(Request $request)
    {
//        dd($request->all());
        $this->validate($request, [
            'restaurant_name'   => 'required',
            'pincode'           => 'required',
            'phone'             => 'required|unique:vendors,mobile,'.\Auth::guard('vendor')->user()->id,
            'address'           => 'required',
            'fssai_lic_no'      => 'required',
            'vendor_commission' => 'required',
            'categories'        => 'required',
            'deal_cuisines'     => 'required',
            'tax'               => 'required',
        ]);
        $vendors                   = Vendors::find(\Auth::guard('vendor')->user()->id);
        $vendors->name             = $request->restaurant_name;
        $vendors->vendor_type      = 'restaurant';
        $vendors->mobile           = $request->phone;
        $vendors->pincode          = $request->pincode;
        $vendors->address          = $request->address;
        $vendors->fssai_lic_no     = $request->fssai_lic_no;
        $vendors->commission       = $request->vendor_commission;
        $vendors->vendor_food_type = $request->type;
        $vendors->tax              = $request->tax;
        $vendors->gst_available    = $request->gst_available;
        $vendors->gst_no           = $request->gst_no;
        $vendors->deal_categories  = implode(',', $request->categories);
        $vendors->deal_cuisines    = implode(',', $request->deal_cuisines);
//
        if ($request->has('image')) {
            $vendors_old=$vendors->image;
            $filename = time() . '-profile-' . rand(100, 999) . '.' . $request->image->extension();
            $request->image->move(public_path('vendors'), $filename);
            $vendors->image = $filename;
            @unlink(public_path('vendors'.$vendors_old));
        } else {
//            $vendors->image  = 'default_restourant_image.jpg';
        }
        if ($request->has('fassai_image')) {
            $vendors_old=$vendors->fassai_image;
            $filename = time() . '-document-' . rand(100, 999) . '.' . $request->fassai_image->extension();
            $request->fassai_image->move(public_path('vendor-documents'), $filename);
            $vendors->licence_image = $filename;
            @unlink(public_path('vendor-documents'.$vendors_old));
        }
        if ($request->has('other_document')) {
            $vendors_old=$vendors->other_document;
            $filename = time() . '-other-document-' . rand(100, 999) . '.' . $request->other_document->extension();
            $request->other_document->move(public_path('vendor-documents'), $filename);
            $vendors->other_document_image = $filename;
            $vendors->other_document       = $request->other_document_name;
            @unlink(public_path('vendor-documents'.$vendors_old));
//            @unlink(public_path('vendors'.\Auth::gaurd('vendor')->user()->other_document));
        }
        if ($request->has('banner_image')) {
            $filename = time() . '-banner-' . rand(100, 999) . '.' . $request->banner_image->extension();
            $request->banner_image->move(public_path('vendor-banner'), $filename);
            $files[]               = $filename;
            $vendors->banner_image = json_encode($files);

        }
        $vendors->save();
//        dd($vendors);
        return redirect()->route('restaurant.profile')->with('message', 'Vendor Details Update  Successfully');

    }
}
