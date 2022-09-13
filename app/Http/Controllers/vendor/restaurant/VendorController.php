<?php

namespace App\Http\Controllers\vendor\restaurant;
use App\Http\Controllers\Controller;
use App\Models\vendors;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VendorController extends Controller
{
    public function set_offline(Request $request)
    {
        vendors::where('id',Auth::guard('vendor')->user()->id)->update(['is_online'=>0]);                
        return redirect()->back()->with('success', 'Now your Restauran is offline.');
        
    }
    public function set_online(Request $request)
    {
        vendors::where('id',Auth::guard('vendor')->user()->id)->update(['is_online'=>1]);        
        return redirect()->back()->with('success', 'Now your Restauran is online.');
        
    }
    public function requireOrderTime()
    {  
         
        $hideSidebar = true;
        return view('vendor.restaurant.globleseting.require_ordertime',compact('hideSidebar'));
    }
}
