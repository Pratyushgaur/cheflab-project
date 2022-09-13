<?php

namespace App\Http\Controllers\vendor\restaurant;

use App\Http\Controllers\Controller;
use App\Models\vendors;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VendorController extends Controller
{
    /*public function set_offline(Request $request)
    {
        vendors::where('id', Auth::guard('vendor')->user()->id)->update(['is_online' => 0]);
        return redirect()->back()->with('success', 'Now your Restauran is offline.');
    }
    public function set_online(Request $request)
    {
        vendors::where('id', Auth::guard('vendor')->user()->id)->update(['is_online' => 1]);
        return redirect()->back()->with('success', 'Now your Restauran is online.');
    }
    */
    public function restaurent_status(Request $request)
    {

        if ($request->restaurent_status == 'on'){
            vendors::where('id', Auth::guard('vendor')->user()->id)->update(['is_online' => 1]);
            $data=['status'=>'success','msg'=>'Now your restaurant is online','rest_status'=>'on'];
        }

        else{
            vendors::where('id', Auth::guard('vendor')->user()->id)->update(['is_online' => 0]);
            $data=['status'=>'success','msg'=>'Now your restaurant is offline','rest_status'=>'off'];
        }
            return response()->json($data, 200);

    }
}
